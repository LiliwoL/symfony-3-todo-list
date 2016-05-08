# TODO List

Just another TODO app to show some basic and new features on Symfony 3.

## Installation

	composer installù
	
## Run the server
   
   php bin/console server:run

Check the application: http://localhost:8000/

## Commands

I have used the following comamnds, let me write a little note for me to remember :)
 
### Generate a Doctrine Entity

    php bin\console doctrine:generate:entity
    
### Update Database Schema

    php bin\console doctrine:schema:update --force
 
### Generate a Form from a Doctrine Entity

    doctrine:generate:entity AppBundle:Todo

## Unit tests

    phpunit

## TODO

- On the TODO list and details, check if the todo variable is empty
- Add the submit button on the view, not on the model or controller
- Set class properties in the view instead on the form object -> http://stackoverflow.com/questions/6734821/how-to-set-a-class-attribute-to-a-symfony2-form-input
- render a form with a generic form cycle on elements
- Datetime field css
- Breadcrumbs, add a bundle or set it manually
- Controller functional test
- Add a category and priority table and use some relationships
