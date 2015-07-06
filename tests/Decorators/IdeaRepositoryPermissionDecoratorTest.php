<?php

use Mockery as m;

class IdeaRepositoryPermissionDecoratorTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->mockRepository = m::mock('App\Contracts\RepositoryInterface');
		$this->mockUser = m::mock('User');
		$this->decorator = new App\Decorators\IdeaRepositoryPermissionDecorator(
			$this->mockRepository,
			$this->mockUser
		);
	}

	public function tearDown() {
		m::close();
	}

	public function testCanBeInstantiated() {
		$this->assertInstanceOf(
			'App\Decorators\IdeaRepositoryPermissionDecorator',
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

	public function testSaveNewWithSufficientUserPermissions() {
		$mockIdea = m::mock('Model');
		$mockResult = 'result';

		$this->mockUser
			->shouldReceive('can')->with('add_ideas')->andReturn(true);

		$this->mockRepository
			->shouldReceive('save')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->save($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	public function testSaveUpdateWithSufficientUserPermissions() {
		$mockIdea = m::mock('Model');
		$mockResult = 'result';

		$mockIdea->id = 5;

		$this->mockUser
			->shouldReceive('can')->with('update_ideas')->andReturn(true);

		$this->mockRepository
			->shouldReceive('save')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->save($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	/**
	 * @expectedException App\Exceptions\AuthorizationException
	 */
	public function testSaveNewFailsWithInsufficientUserPermissions() {
		$mockIdea = m::mock('Model');

		$this->mockUser
			->shouldReceive('can')->with('add_ideas')->andReturn(false);

		$this->decorator->save($mockIdea);
	}

	/**
	 * @expectedException App\Exceptions\AuthorizationException
	 */
	public function testSaveUpdateFailsWithInsufficientUserPermissions() {
		$mockIdea = m::mock('Model');
		$mockIdea->id = 5;

		$this->mockUser
			->shouldReceive('can')->with('update_ideas')->andReturn(false);

		$this->decorator->save($mockIdea);
	}

	public function testDeleteWithSufficientUserPermissions() {
		$mockIdea = m::mock('Model');
		$mockResult = true;

		$this->mockUser
			->shouldReceive('can')->with('delete_ideas')->andReturn(true);

		$this->mockRepository
			->shouldReceive('delete')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->delete($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	/**
	 * @expectedException App\Exceptions\AuthorizationException
	 */
	public function testDeleteFailsWithInsufficientUserPermissions() {
		$mockIdea = m::mock('Model');

		$this->mockUser
			->shouldReceive('can')->with('delete_ideas')->andReturn(false);

		$this->mockRepository
			->shouldReceive('delete')->with($mockIdea);

		$this->decorator->delete($mockIdea);
	}

	public function testPurgeWithSufficientUserPermissions() {
		$mockIdea = m::mock('Model');
		$mockResult = true;

		$this->mockUser
			->shouldReceive('can')->with('delete_ideas')->andReturn(true);

		$this->mockRepository
			->shouldReceive('purge')->with($mockIdea)->andReturn($mockResult);

		$result = $this->decorator->purge($mockIdea);

		$this->assertSame($result, $mockResult);
	}

	/**
	 * @expectedException App\Exceptions\AuthorizationException
	 */
	public function testPurgeFailsWithInsufficientUserPermissions() {
		$mockIdea = m::mock('Model');

		$this->mockUser
			->shouldReceive('can')->with('delete_ideas')->andReturn(false);

		$this->mockRepository
			->shouldReceive('purge')->with($mockIdea);

		$this->decorator->purge($mockIdea);
	}

}
