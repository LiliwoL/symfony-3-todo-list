# TODO List

Just another TODO app to show some basic and new features on Symfony 3.

## Installation

	composer installù
	
## Run the server
   
   php bin/console server:run

Check the application: http://localhost:8000/

## Unit tests

    phpunit

## TODO

- Use the entity repository to get data as a model
- Move the form in a class
- On the TODO list and details, check if the todo variable is empty
- Add the submit button on the view, not on the model or controller
- Controller refactoring
- Set class properties in the view instead on the form object -> http://stackoverflow.com/questions/6734821/how-to-set-a-class-attribute-to-a-symfony2-form-input
- render a form with a generic form cycle on elements
- Datetime field css
- Breadcrumbs
- Add a category and priority table and use some relationships
- Controller unit test
