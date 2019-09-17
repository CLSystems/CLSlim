<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use CLSlim\Controllers\GetActionBase;
use CLSlim\Middleware\ResponseBody;
use CLSlim\Models\ModelBase;

/**
 * Class GetActionTest
 */
final class GetActionTest extends TestCase
{
	/**
	 *
	 */
    public function testGetAction(): void
    {
        $arg = ['id' => 1];
        $model = new MockModel(false);
        $mockGetAction = new MockGetAction($model);

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $responseBody = new ResponseBody();

        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $result = $mockGetAction->__invoke($request, $response, $arg);

        $bodyStream = $result->getBody();
        $bodyStream->rewind();
        $body = $bodyStream->getContents();
        $json = json_decode($body, true);

        $this->assertEquals(['id' => 1, 'test' => true, 'extra' => 32.3], $json['data']);
        $this->assertEquals(200, $json['status']);
        $this->assertEquals(200, $result->getStatusCode());
    }

	/**
	 *
	 */
    public function testGetAction404(): void
    {
        $arg = ['id' => 1];
        $model = new MockModel(true);
        $mockGetAction = new MockGetAction($model);

        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        $responseBody = new ResponseBody();

        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $result = $mockGetAction->__invoke($request, $response, $arg);

        $bodyStream = $result->getBody();
        $bodyStream->rewind();
        $body = $bodyStream->getContents();
        $json = json_decode($body, true);

        $this->assertEquals(null, $json['data']);
        $this->assertEquals(404, $json['status']);
        $this->assertEquals(404, $result->getStatusCode());
    }
}

/**
 * Class MockGetAction
 */
class MockGetAction extends GetActionBase
{
    public function __construct(MockModel $model)
    {
        $this->model = $model;
    }

    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        return parent::__invoke($request, $response, $args);
    }
}

/**
 * Class MockModel
 */
class MockModel extends ModelBase
{
	/**
	 *
	 */
    public const FIELDS = [
        'id' => 'integer',
        'test' => 'boolean',
        'protected' => '*string'
    ];

	/**
	 * @var bool
	 */
    protected $findFail = false;

	/**
	 * MockModel constructor.
	 *
	 * @param bool $findFail
	 */
    public function __construct(bool $findFail)
    {
        $this->findFail = $findFail;
    }

	/**
	 * @param mixed $id
	 * @param array $columns
	 * @return $this|ModelBase|ModelBase[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
	 */
    public function find($id, $columns = ['*'])
    {
        if ($this->findFail) {
            return null;
        }

        return $this;
    }

	/**
	 * @return array
	 */
    public function toArray(): array
    {
        return [
            'id' => 1,
            'test' => true,
            'protected' => 'do not show',
            'extra' => 32.3
        ];
    }
}
