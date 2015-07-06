# Fluent Repository Decorators
This branch contains a few experimental things:

1) A repository interface with a base (Eloquent) implementation that handles crud for all repositories that extend from it.

2) A Fluent interface for applying filters on a specific repository implementation (i.e. idea repository).

3) Repository decorators that add additional functionality to repositories, such as validation, authorization, and mapping API filter inputs into repository filter method calls.

## Example Usage
```IdeaController.php``` has the following example usage:

```php
// Decorate the Idea Repository with permission checks, validation checks, and API specific logic
$ideaRepository =
new IdeaRepositoryPermissionDecorator(
	new IdeaRepositoryValidationDecorator(
		new IdeaRepositoryApiDecorator($this->ideaRepository, $filters),
		new IdeaValidator
	),
	$currentUser
);

// Call our get method as per usual
return $ideaRepository->get(['*']);
```

This example is for demonstration purposes only. Ideally the controller would not be responsible for composing nested sets of decorators - that could be deferred to a service or a factory class.

Here we assume that our controller has the idea repository injected into it. This example illustrates how decorators then wrap the repository to add additional functionality, such as validation, authorizaton, and mapping of API values. This allows the repository itself to remain dumb (only responsible for crud operations).

This allows each decorator to maintain a small scope, giving them fewer responsibilities and making them easier to test. Furthermore, when you want to extend the functionality of a repository you don't neccessarily need to change it; you can enhance behaviour by applying additional decorators.

## Install & Run Tests
```
git clone https://github.com/crhayes/fluent-repository-decorators.git
cd fluent-repository-decorators
composer install
phpunit
```
