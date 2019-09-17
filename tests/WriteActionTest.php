<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use CLSlim\Controllers\WriteActionBase;
use CLSlim\Middleware\ResponseBody;
use CLSlim\Models\ModelBase;

/**
 * Class WriteActionTest
 */
final class WriteActionTest extends TestCase
{
	/**
	 *
	 */
    public function testWriteActionInvoke(): void
    {
        $model = new MockModelWriteAction(false);

        $writeAction = new MockWriteAction($model);

        $responseBody = new MockResponseBodyWriteAction();

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $response = $this->createMock(Response::class);

        $result = $writeAction($request, $response);

        $bodyStream = $result->getBody();
        $bodyStream->rewind();
        $contents = $bodyStream->getContents();
        $json = json_decode($contents, false);
        $data = $json->data;

        $this->assertEquals('test', $data->extra);
    }

	/**
	 *
	 */
    public function testWriteActionFindFailure(): void
    {
        $model = new MockModelWriteAction(true);

        $writeAction = new MockWriteAction($model);

        $responseBody = new MockResponseBodyWriteAction();

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $response = $this->createMock(Response::class);

        $result = $writeAction($request, $response);

        $bodyStream = $result->getBody();
        $bodyStream->rewind();
        $contents = $bodyStream->getContents();
        $json = json_decode($contents, false);
        $data = $json->data;

        $this->assertFalse($json->success);
        $this->assertEquals(404, $json->status);
        $this->assertNull($data);
    }

	/**
	 *
	 */
    public function testWriteActionSaveFailure(): void
    {
        $model = new MockModelWriteAction(false, true);

        $writeAction = new MockWriteAction($model);

        $responseBody = new MockResponseBodyWriteAction();

        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getAttribute')
            ->with('response_body')
            ->willReturn($responseBody);

        $response = $this->createMock(Response::class);

        $result = $writeAction($request, $response);

        $bodyStream = $result->getBody();
        $bodyStream->rewind();
        $contents = $bodyStream->getContents();
        $json = json_decode($contents, false);
        $data = $json->data;

        $this->assertFalse($json->success);
        $this->assertEquals(500, $json->status);
        $this->assertNull($data);
    }
}

/**
 * Class MockWriteAction
 */
class MockWriteAction extends WriteActionBase
{
	/**
	 * @var ModelBase
	 */
    protected $model;

	/**
	 * MockWriteAction constructor.
	 *
	 * @param ModelBase $model
	 */
    public function __construct(ModelBase $model)
    {
        $this->model = $model;
    }
}

/**
 * Class MockResponseBodyWriteAction
 */
class MockResponseBodyWriteAction extends ResponseBody
{
	/**
	 * @return array
	 */
    public function getParsedRequest(): array
    {
        return [
            'id' => 321,
            'created_at' => time(),
            'updated_at' => time(),
            'bogus' => 'garbage',
            'extra' => 'test',
            'protected' => 'blah'
        ];
    }
}

/**
 * Class MockModelWriteAction
 */
class MockModelWriteAction extends ModelBase
{
	/**
	 * @var bool
	 */
    protected $findFailure = false;
    protected $saveFailure = false;

	/**
	 *
	 */
    public const FIELDS = [
        'id' => '*integer',
        'test' => 'true',
        'protected' => '*bool',
        'extra' => 'string'
    ];

	/**
	 * MockModelWriteAction constructor.
	 *
	 * @param bool $findFailure
	 * @param bool $saveFailure
	 */
    public function __construct(bool $findFailure, bool $saveFailure = false)
    {
        $this->findFailure = $findFailure;
        $this->saveFailure = $saveFailure;
    }

	/**
	 * @return string
	 */
    public function getPrimaryKey(): string
    {
        return 'id';
    }

	/**
	 * @return string
	 */
    public function getTableName(): string
    {
        return 'mock_table';
    }

	/**
	 * @param mixed $id
	 * @param array $columns
	 * @return $this|ModelBase|ModelBase[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
	 */
    public function find($id, $columns = ['*'])
    {
        if ($this->findFailure) {
            return null;
        }

        return $this;
    }

	/**
	 * @param array $options
	 * @return bool
	 */
    public function save(array $options = [])
    {
        return !$this->saveFailure;
    }
}
