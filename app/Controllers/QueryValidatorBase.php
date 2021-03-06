<?php
declare(strict_types=1);

namespace CLSlim\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\Route;
use CLSlim\Middleware\ResponseBody;

/**
 * Class QueryValidatorBase
 *
 * @package CLSlim\Controllers
 */
abstract class QueryValidatorBase
{
    /**
     * @var array Model::FIELDS
     */
    protected $modelFields = [];

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

        /** @var Route $route */
        $route = $request->getAttribute('route');
        $value = $route->getArgument('value');

        switch ($value)
        {
            case '*':
                break;

            case '_':
                $columnCount = 0;
                foreach ($parsedRequest as $item => $value) {
                    if ($item{0} === '_') {
                        $columnName = substr($item, 1);
                        if (!array_key_exists($columnName, $this->modelFields)) {
                            $responseBody->registerParam('invalid', $columnName, null);
                        } else {
                            $columnCount++;
                        }
                    }
                }

                // This option requires at least one __ColumnName=value
                if ($columnCount === 0) {
                    $responseBody->registerParam('required', '__column', 'string');
                }

                break;

            default:
                if (!array_key_exists($parsedRequest['column_name'], $this->modelFields)) {
                    $responseBody->registerParam('invalid', 'column_name', 'string');
                }
                break;
        }

        // Are there any missing or required request data points?
        if ($responseBody->hasMissingRequiredOrInvalid()) {
            // Set the response body to invalid request status and short circuit any further processing
            $responseBody = $responseBody
                ->setData(null)
                ->setStatus(400);
            return $responseBody();
        }

        // All validations passed so we continue to process the request.
        return $handler->handle($request);
    }
}
