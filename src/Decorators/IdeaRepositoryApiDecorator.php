<?php namespace App\Decorators;

use App\Contracts\RepositoryInterface;
use App\Contracts\IdeaRepositoryInterface;

class IdeaRepositoryApiDecorator implements RepositoryInterface {

	protected $ideaRepository;
	protected $filters;

	public function __construct(IdeaRepositoryInterface $ideaRepository, array $filters = []) {
		$this->ideaRepository = $ideaRepository;
		$this->filters = $filters;
	}

	public function get(array $columns) {
		$query = $this->ideaRepository->newQuery();

		if (array_key_exists('ids', $this->filters)) {
			$query->filterByIds($this->filters['ids']);
		}

		if (array_key_exists('user', $this->filters)) {
			$query->filterByUser($this->filters['user']);
		}

		return $query->get($columns);
	}

	public function find($id, array $columns) {
		//
	}

	public function paginate($perPage, $page, array $columns) {
		//
	}

	public function chunk($perChunk, Closure $callback) {
		//
	}

	public function save(Model $model) {
		//
	}

	public function delete(Model $model) {
		//
	}

	public function purge(Model $model) {
		//
	}

}
