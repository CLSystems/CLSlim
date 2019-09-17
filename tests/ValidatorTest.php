<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Respect\Validation\Validator as V;
use Slim\Psr7\Request;
use CLSlim\Controllers\WriteValidatorBase;
use CLSlim\Middleware\ResponseBody;

/**
 * Class ValidatorTest
 */
final class ValidatorTest extends TestCase
{
	/**
	 *
	 */
    public function testValidatorInvalid(): void
    {
        $validator = new MockValidator(false);

        $responseBody = new MockValidatorResponseBody();
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);
        $requestHandler = $this->createMock(RequestHandler::class);

        $result = $validator->__invoke($request, $requestHandler);
    }

	/**
	 *
	 */
    public function testValidatorValid(): void
    {
        $validator = new MockValidator(true);

        $responseBody = new MockValidatorResponseBody();
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);
        $requestHandler = $this->createMock(RequestHandler::class);

        $result = $validator->__invoke($request, $requestHandler);
    }
}

/**
 * Class MockValidator
 */
class MockValidator extends WriteValidatorBase
{
	/**
	 * @var bool
	 */
    protected $isValid = false;

	/**
	 * MockValidator constructor.
	 *
	 * @param bool $isValid
	 */
    public function __construct(bool $isValid)
    {
        $this->isValid = $isValid;
    }

	/**
	 * @param ResponseBody $responseBody
	 * @param array $parsedRequest
	 */
    public function processValidation(ResponseBody $responseBody, array &$parsedRequest): void
    {
        if (!V::key('extra')->validate($parsedRequest)) {
            $responseBody->registerParam('optional', 'extra', null);
        }

        if (!$this->isValid) {
            if (!V::primeNumber()->validate($parsedRequest['id'])) {
                $responseBody->registerParam('invalid', 'id', 'integer');
            }
        }
    }
}

/**
 * Class MockValidatorResponseBody
 */
class MockValidatorResponseBody extends ResponseBody
{
	/**
	 * @return array
	 */
    public function getParsedRequest(): array
    {
        return [
            'id' => 22,
            'test' => true
        ];
    }
}
