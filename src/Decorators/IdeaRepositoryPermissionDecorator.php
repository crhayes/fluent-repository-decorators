<?php namespace App\Decorators;

use App\Contracts\RepositoryInterface;

class IdeaRepositoryPermissionDecorator implements RepositoryInterface {

	protected $repository;
	protected $user;

	public function __construct(RepositoryInterface $repository, User $user) {
		$this->repository = $repository;
		$this->user = $user;
	}

	public function get($columns) {
		return $this->repository->get($columns);
	}

	public function find($id, $columns) {
		return $this->repository->find($id, $columns);
	}

	public function paginate($perPage, $page, $columns) {
		return $this->repository->paginate($perPage, $page, $columns);
	}

	public function chunk($perChunk, Closure $callback) {
		return $this->repository->chunk($perChunk, $callback);
	}

	public function save(Model $model) {
		if ( ! isset($model->id) && ! $this->user->can('add_ideas') ) {
			throw new AuthorizationException('User is not permitted to add ideas.');
		}

		if (isset($model->id) && ! $this->user->can('update_ideas')) {
			throw new AuthorizationException('User is not permitted to update ideas.');
		}

		return $this->repository->save($model);
	}

	public function delete(Model $model) {
		if ( ! $this->user->can('delete_ideas') ) {
			throw new AuthorizationException('User is not permitted to delete ideas.');
		}

		return $this->repository->delete($model);
	}

	public function purge(Model $model) {
		if ( ! $this->user->can('delete_ideas') ) {
			throw new AuthorizationException('User is not permitted to delete ideas.');
		}

		return $this->repository->purge($model);
	}

}
