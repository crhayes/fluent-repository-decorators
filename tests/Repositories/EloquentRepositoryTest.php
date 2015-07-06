<?php

use Mockery as m;
use App\Repositories\EloquentRepository;

class ModelRepository extends EloquentRepository {};

class EloquentRepositoryTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->mockModel = m::mock('Illuminate\Database\Eloquent\Model');
		$this->mockPaginator = m::mock('App\Paginator');
		$this->modelRepository = new ModelRepository($this->mockModel, $this->mockPaginator);
	}

	public function tearDown() {
		m::close();
	}

	public function testCanBeInstantiated() {
		$this->assertInstanceOf('App\Repositories\EloquentRepository', $this->modelRepository);
	}

	public function testCanGetWithDefaults() {
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('get')->once()->with(['*'])->andReturn($mockReturn);

		$result = $this->modelRepository->get();

		$this->assertSame($result, $mockReturn);
	}

	public function testCanGetWithSpecificColumns() {
		$mockColumns = ['idea', 'title'];
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('get')->once()->with($mockColumns)->andReturn($mockReturn);

		$result = $this->modelRepository->get($mockColumns);

		$this->assertSame($result, $mockReturn);
	}

	public function testCanFindWithDefaults() {
		$id = 1;
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('find')->once()->with($id, ['*'])->andReturn($mockReturn);

		$result = $this->modelRepository->find($id);

		$this->assertSame($result, $mockReturn);
	}

	public function testCanFindWithSpecificColumns() {
		$id = 1;
		$mockColumns = ['idea', 'title'];
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('find')->once()->with($id, $mockColumns)->andReturn($mockReturn);

		$result = $this->modelRepository->find($id, $mockColumns);

		$this->assertSame($result, $mockReturn);
	}

	public function testCanPaginateWithDefaults() {
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('take')->once()->with(10)->andReturn($this->mockModel)
			->shouldReceive('offset')->once()->with(0)->andReturn($this->mockModel)
			->shouldReceive('get')->once()->with(['*'])->andReturn('result')
			->shouldReceive('count')->once()->andReturn(1);

		$this->mockPaginator
			->shouldReceive('make')->once()->with('result', 1, 10, 1)->andReturn($mockReturn);

		$result = $this->modelRepository->paginate();

		$this->assertSame($result, $mockReturn);
	}

	public function testCanPaginateWithSpecificColumns() {
		$mockColumns = ['idea', 'title'];
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('take')->once()->with(50)->andReturn($this->mockModel)
			->shouldReceive('offset')->once()->with(50)->andReturn($this->mockModel)
			->shouldReceive('get')->once()->with($mockColumns)->andReturn('result')
			->shouldReceive('count')->once()->andReturn(1);

		$this->mockPaginator
			->shouldReceive('make')->once()->with('result', 1, 50, 2)->andReturn($mockReturn);

		$result = $this->modelRepository->paginate(50, 2, $mockColumns);

		$this->assertSame($result, $mockReturn);
	}

	public function testCanChunk() {
		$perChunk = 50;
		$callback = function () {};
		$mockReturn = ['data'];

		$this->mockModel
			->shouldReceive('chunk')->with($perChunk, $callback)->andReturn($mockReturn);

		$result = $this->modelRepository->chunk($perChunk, $callback);

		$this->assertSame($result, $mockReturn);
	}

	public function testCanSave() {
		$this->mockModel
			->shouldReceive('save')->once()
			->andReturn(true);

		$result = $this->modelRepository->save($this->mockModel);

		$this->assertTrue($result);
	}

	public function testCanDelete() {
		$this->mockModel
			->shouldReceive('delete')->once()
			->andReturn(true);

		$result = $this->modelRepository->delete($this->mockModel);

		$this->assertTrue($result);
	}

	public function testCanPurge() {
		$this->mockModel
			->shouldReceive('forceDelete')->once()
			->andReturn(true);

		$result = $this->modelRepository->purge($this->mockModel);

		$this->assertTrue($result);
	}

}
