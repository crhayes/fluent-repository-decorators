<?php namespace App\Repositories;

use Idea;
use App\Contracts\IdeaRepositoryInterface;

class IdeaRepository extends EloquentRepository implements IdeaRepositoryInterface {

	protected $model;

	public function __construct(Idea $model) {
		$this->model = $model;
	}

	public function filterByIds(array $ids) {
		$this->model = $this->model->byIds($ids);

		return $this;
	}

	public function filterByUser($userId) {
		$this->model = $this->model->byUser($userId);

		return $this;
	}

}
