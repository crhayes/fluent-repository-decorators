<?php

use Mockery as m;

class IdeaRepositoryApiDecoratorTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->mockIdea = m::mock('Idea');
		$this->mockIdeaRepository = m::mock('App\Repositories\IdeaRepository', [$this->mockIdea]);
	}

	public function tearDown() {
		m::close();
	}

	public function testCanBeInstantiated() {
		$decorator = new App\Decorators\IdeaRepositoryApiDecorator($this->mockIdeaRepository);

		$this->assertInstanceOf(
			'App\Decorators\IdeaRepositoryApiDecorator',
			$decorator
		);
	}

	public function testGetWithoutFilters() {
		$columns = ['*'];
		$mockResult = ['result'];
		$decorator = new App\Decorators\IdeaRepositoryApiDecorator($this->mockIdeaRepository);

		$this->mockIdeaRepository
			->shouldReceive('newQuery')->once()->andReturn(m::self())
			->shouldReceive('get')->once()->with($columns)->andReturn($mockResult);

		$result = $decorator->get($columns);

		$this->assertSame($result, $mockResult);
	}

	public function testGetWithIdsFilter() {
		$filters = ['ids' => [1, 2, 3]];
		$columns = ['*'];
		$mockResult = ['result'];
		$decorator = new App\Decorators\IdeaRepositoryApiDecorator($this->mockIdeaRepository, $filters);

		$this->mockIdeaRepository
			->shouldReceive('newQuery')->once()->andReturn(m::self())
			->shouldReceive('filterByIds')->once()->with($filters['ids'])
			->shouldReceive('get')->once()->with($columns)->andReturn($mockResult);

		$result = $decorator->get($columns);

		$this->assertSame($result, $mockResult);
	}

	public function testGetWithUserFilter() {
		$filters = ['user' => 1];
		$columns = ['*'];
		$mockResult = ['result'];
		$decorator = new App\Decorators\IdeaRepositoryApiDecorator($this->mockIdeaRepository, $filters);

		$this->mockIdeaRepository
			->shouldReceive('newQuery')->once()->andReturn(m::self())
			->shouldReceive('filterByUser')->once()->with($filters['user'])
			->shouldReceive('get')->once()->with($columns)->andReturn($mockResult);

		$result = $decorator->get($columns);

		$this->assertSame($result, $mockResult);
	}

	public function testGetWithIdsAndUserFilter() {
		$filters = [
			'ids' => [1, 2, 3],
			'user' => 1
		];
		$columns = ['*'];
		$mockResult = ['result'];
		$decorator = new App\Decorators\IdeaRepositoryApiDecorator($this->mockIdeaRepository, $filters);

		$this->mockIdeaRepository
			->shouldReceive('newQuery')->once()->andReturn(m::self())
			->shouldReceive('filterByIds')->once()->with($filters['ids'])
			->shouldReceive('filterByUser')->once()->with($filters['user'])
			->shouldReceive('get')->once()->with($columns)->andReturn($mockResult);

		$result = $decorator->get($columns);

		$this->assertSame($result, $mockResult);
	}

}
