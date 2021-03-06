<?php
declare(strict_types=1);

namespace CLSlim\Controllers\Sample;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Respect\Validation\Validator as V;
use CLSlim\Middleware\ResponseBody;

/**
 * Class SampleGetValidator
 *
 * @package CLSlim\Controllers\Sample
 */
class SampleGetValidator
{
	/**
	 * @param Request $request
	 * @param RequestHandler $handler
	 * @return ResponseInterface
	 */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        /** @var ResponseBody $responseBody */
        $responseBody = $request->getAttribute('response_body');
        $parsedRequest = $responseBody->getParsedRequest();

        // Register Roman numerals as an invalid request
        if (V::roman()->validate($parsedRequest['id'])) {
            $responseBody->registerParam('invalid', 'id', 'string');
        }

        // Are there any missing or required request data points?
        if ($responseBody->hasMissingRequiredOrInvalid()) {
            // Set the response body to invalid request status and short circuit any further processing
            $responseBody = $responseBody
                ->setData(null)
                ->setStatus(400)
                ->setMessage('Roman numerals are not allowed.');
            return $responseBody();
        }

        // All validations passed so we continue to process the request.
        return $handler->handle($request);
    }
}
