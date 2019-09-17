<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Interfaces\RouteCollectorProxyInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use CLSlim\Controllers\Sample\SampleController;
use CLSlim\Controllers\Sample\SampleGetAction;
use CLSlim\Controllers\Sample\SampleGetValidator;
use CLSlim\Middleware\ResponseBody;

/**
 * Class SampleTest
 */
final class SampleTest extends TestCase
{
	/**
	 *
	 */
    public function testSampleController(): void
    {
        $sampleController = new SampleController();
        $group = $this->createMock(RouteCollectorProxyInterface::class);

        $group->expects($this->once())
            ->method('get')
            ->with('/sample/{id}');
        $sampleController->register($group);
    }

	/**
	 *
	 */
    public function testSampleGetAction(): void
    {
        $sampleGetAction = new SampleGetAction();

        $responseBody = new ResponseBody();

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->willReturn($responseBody);
        $response = $this->createMock(Response::class);
        $id = uniqid('', false);
        $arg = ['id' => $id];

        $result = $sampleGetAction($request, $response, $arg);

        $body = $result->getBody();
        $body->rewind();
        $contents = $body->getContents();
        $json = json_decode($contents, false);

        $this->assertEquals(200, $json->status);
        $this->assertEquals($id, $json->data->id);
        $this->assertEquals('Sample test', $json->message);
    }

	/**
	 *
	 */
    public function testSampleGetValidator(): void
    {
        $sampleGetValidator = new SampleGetValidator();
        $id = uniqid('', false);
        $responseBody = new MockSampleRequestBody($id);

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $requestHandler = $this->createMock(RequestHandler::class);
        $result = $sampleGetValidator($request, $requestHandler);
    }

	/**
	 *
	 */
    public function testSampleGetValidatorFailure(): void
    {
        $sampleGetValidator = new SampleGetValidator();
        $id = 'IV';
        $responseBody = new MockSampleRequestBody($id);

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $requestHandler = $this->createMock(RequestHandler::class);
        $result = $sampleGetValidator($request, $requestHandler);

        $body = $result->getBody();
        $body->rewind();
        $contents = $body->getContents();
        $json = json_decode($contents, false);

        $this->assertEquals(400, $json->status);
        $this->assertNull($json->data);
        $this->assertEquals('Roman numerals are not allowed.', $json->message);
    }
}

/**
 * Class MockSampleRequestBody
 */
class MockSampleRequestBody extends ResponseBody
{
	/**
	 * @var string
	 */
    protected $id;

	/**
	 * MockSampleRequestBody constructor.
	 *
	 * @param string $id
	 */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

	/**
	 * @return array
	 */
    public function getParsedRequest(): array
    {
        return [
            'id' => $this->id,
            'test' => true
        ];
    }
}
