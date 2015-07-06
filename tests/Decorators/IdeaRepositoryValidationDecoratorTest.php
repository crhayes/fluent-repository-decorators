<?php

use Mockery as m;

class IdeaRepositoryValidationDecoratorTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->mockRepository = m::mock('App\Contracts\RepositoryInterface');
		$this->mockIdeaValidator = m::mock('IdeaValidator');
		$this->decorator = new App\Decorators\IdeaRepositoryValidationDecorator(
			$this->mockRepository,
			$this->mockIdeaValidator
		);
	}

	public function tearDown() {
		m::close();
	}

	public function testCanBeInstantiated() {
		$this->assertInstanceOf(
			'App\Decorators\IdeaRepositoryValidationDecorator',
			$this->decorator
		);
	}

	public function testGet() {
		$columns = ['*'];
		$mockResult = 'result';

		$this->mockRepository
			->shouldReceive('get')->once()->with($columns)->andReturn($mockResult);

		$result = $this->decorator->get($columns);

		$this->assertSame($result, $mockResult);
	}

	public function testFind() {
		$id = 1;
		$columns = ['*'];
		$mockResult = 'result';

		$this->mockRepository
			->shouldReceive('find')->once()->with($id, $columns)->andReturn($mockResult);

		$result = $this->decorator->find($id, $columns);

		$this->assertSame($result, $mockResult);
	}

	public function testPaginate() {
		$perPage = 10;
		$page = 1;
		$columns = ['*'];
		$mockResult = 'result';

		$this->mockRepository
			->shouldReceive('paginate')->once()->with($perPage, $page, $columns)->andReturn($mockResult);

		$result = $this->decorator->paginate($perPage, $page, $columns);

		$this->assertSame($result, $mockResult);
	}

	public function testChunk() {
		$perChunk = 10;
		$callback = function () {};
		$mockResult = 'result';

		$this->mockRepository
			->shouldReceive('chunk')->once()->with($perChunk, $callback)->andReturn($mockResult);

		$result = $this->decorator->chunk($perChunk, $callback);

		$this->assertSame($result, $mockResult);
	}

	public function testSaveNewWhenValidationPasses() {
		$mockIdea = m::mock('Model');
		$mockResult = 'result';

		$this->mockIdeaValidator
			->shouldReceive('validateSave')->with($mockIdea)->andReturn(true);

		$this->mockRepository
			->shouldReceive('save')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->save($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	public function testSaveUpdateWhenValidationPasses() {
		$mockIdea = m::mock('Model');
		$mockResult = 'result';

		$mockIdea->id = 5;

		$this->mockIdeaValidator
			->shouldReceive('validateUpdate')->with($mockIdea)->andReturn(true);

		$this->mockRepository
			->shouldReceive('save')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->save($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	/**
	 * @expectedException App\Exceptions\ValidationException
	 */
	public function testSaveNewFailsWhenValidationFails() {
		$mockIdea = m::mock('Model');

		$this->mockIdeaValidator
			->shouldReceive('validateSave')->with($mockIdea)->andReturn(false)
			->shouldReceive('getErrors');

		$this->decorator->save($mockIdea);
	}

	/**
	 * @expectedException App\Exceptions\ValidationException
	 */
	public function testSaveUpdateFailsWhenValidationFails() {
		$mockIdea = m::mock('Model');
		$mockIdea->id = 5;

		$this->mockIdeaValidator
			->shouldReceive('validateUpdate')->with($mockIdea)->andReturn(false)
			->shouldReceive('getErrors');

		$this->decorator->save($mockIdea);
	}

	public function testDelete() {
		$mockIdea = m::mock('Model');
		$mockResult = true;

		$this->mockRepository
			->shouldReceive('delete')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->delete($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	public function testPurge() {
		$mockIdea = m::mock('Model');
		$mockResult = true;

		$this->mockRepository
			->shouldReceive('purge')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->purge($mockIdea);

		$this->assertSame($result, $mockResult);
	}

}
