<?php namespace App\Repositories;

use Closure;
use App\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class EloquentRepository implements RepositoryInterface {

	protected $model;

	public function __construct(Model $model) {
		$this->model = $model;
	}

	public function get($columns = ['*']) {
		return $this->model->get($columns);
	}

	public function find($id, $columns = ['*']) {
		return $this->model->find($id, $columns);
	}

	public function paginate($perPage = 10, $page = 1, $columns = ['*']) {
		$query = $this->model->take($perPage)->offset($perPage * ($page - 1));

        return new LengthAwarePaginator($query->get(), $query->count(), $perPage, $page);
	}

	public function chunk($perChunk, Closure $callback) {
		return $this->model->chunk($perChunk, $callback);
	}

	public function save(Model $model) {
		return $model->save();
	}

	public function delete(Model $model) {
		return $model->delete();
	}

	public function purge(Model $model) {
		return $model->forceDelete();
	}

}
