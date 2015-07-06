<?php namespace App\Contracts;

interface IdeaRepositoryInterface extends RepositoryInterface {

	public function filterByIds(array $ids);

	public function filterByUser($userId);

}
