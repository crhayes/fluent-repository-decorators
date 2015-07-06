<?php namespace App;

class IdeaController {

	/**
	 * @var IdeaRepositoryInterface
	 */
	protected $ideaRepository;

	/**
	 * Instantiate our dependencies.
	 *
	 * @param IdeaRepositoryInterface $ideaRepository
	 */
	public function __construct(IdeaRepositoryInterface $ideaRepository) {
		$this->ideaRepository = $ideaRepository;
	}

	/**
	 * Get a listing of ideas.
	 *
	 * @return Collection
	 */
	public function index() {
		// Get the currently authenticated user
		$currentUser = Auth::user();

		// Fetch filter query params from the API
		$filters = Input::only(['ids', 'user']);

		// Decorate the Idea Repository with API specific logic
		$ideaRepository = new IdeaRepositoryPermissionDecorator(
			new IdeaRepositoryApiDecorator($this->ideaRepository, $filters),
			$currentUser
		);

		// Call our get method as per usual
		return $ideaRepository->get('*');
	}

	/**
	 * Delete an idea.
	 *
	 * @param  int $id
	 * @return bool
	 */
	public function delete($id) {
		// Get the currently authenticated user
		$currentUser = Auth::user();

		// Decorate the Idea Repository with API specific logic
		$ideaRepository = new IdeaRepositoryPermissionDecorator(
			new IdeaRepositoryApiDecorator($this->ideaRepository),
			$currentUser
		);

		// Call our get method as per usual
		$idea = $ideaRepository->find($id, '*');

		// Call to delete our model
		return $ideaRepository->delete($idea);
	}

}
