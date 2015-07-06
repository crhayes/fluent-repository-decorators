<?php namespace App\Decorators;

use Model;
use Closure;
use IdeaValidator;
use App\Exceptions\ValidationException;
use App\Contracts\RepositoryInterface;

class IdeaRepositoryValidationDecorator implements RepositoryInterface {

	protected $repository;
	protected $validator;

	public function __construct(RepositoryInterface $repository, IdeaValidator $validator) {
		$this->repository = $repository;
		$this->validator = $validator;
	}

	public function get(array $columns) {
		return $this->repository->get($columns);
	}

	public function find($id, array $columns) {
		return $this->repository->find($id, $columns);
	}

	public function paginate($perPage, $page, array $columns) {
		return $this->repository->paginate($perPage, $page, $columns);
	}

	public function chunk($perChunk, Closure $callback) {
		return $this->repository->chunk($perChunk, $callback);
	}

	public function save(Model $model) {
		if ( ! isset($model->id) && ! $this->validator->validateSave($model) ) {
			throw new ValidationException($this->validator->getErrors());
		}

		if (isset($model->id) && ! $this->validator->validateUpdate($model)) {
			throw new ValidationException($this->validator->getErrors());
		}

		return $this->repository->save($model);
	}

	public function delete(Model $model) {
		return $this->repository->delete($model);
	}

	public function purge(Model $model) {
		return $this->repository->purge($model);
	}

}
