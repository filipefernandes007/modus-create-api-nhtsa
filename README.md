# Modus Create API Exercise

## Requirements

PHP 7.0 or greater

[composer - Dependency Manager for PHP](https://getcomposer.org/download/) 

## Install the Application

Run this commands:

    git clone https://github.com/filipefernandes007/modus-create-api-nhtsa.git
    cd modus-create-api-exercise
    
* Ensure `logs/` is web writable. 

Now run this command:    
    
    composer install 
    
The above command will point your virtual host document root to your new application's `public/` directory.

To run the application in development, and if you not already have the web server running, you can run these command: 

	cd modus-create-api-exercise
	composer start

Run this command in the application directory to run the test suite:

	composer test

After that, you can look at `logs/app.log` to see phpunit tests json results.

That's it!