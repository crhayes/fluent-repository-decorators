<?php namespace App\Decorators;

use App\Contracts\RepositoryInterface;
use App\Contracts\IdeaRepositoryInterface;

class IdeaRepositoryApiDecorator implements RepositoryInterface {

	protected $ideaRepository;
	protected $filters;

	public function __construct(IdeaRepositoryInterface $ideaRepository, $filters = []) {
		$this->ideaRepository = $ideaRepository;
		$this->filters = $filters;
	}

	public function get($columns) {
		$query = $this->ideaRepository->newQuery();

		if ($ids = array_get($this->filters, 'ids')) {
			$query->filterByIds($ids);
		}

		if ($user = array_get($this->filters, 'user')) {
			$query->filterByUser($user);
		}

		return $query->get($columns);
	}

	public function find($id, $columns) {
		//
	}

	public function paginate($perPage, $page, $columns) {
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
