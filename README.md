# Modus Create API

## Requirements

PHP 7.0 or greater

[composer - Dependency Manager for PHP](https://getcomposer.org/download/) 

## Install the Application

Run this commands from the directory in which you want to install this API.

    git clone https://gitlab.com/filipefernandes007/modus-create-api-exercise.git
    cd modus-create-api-exercise
    composer install 
    
* Ensure `logs/` is web writable.

The above command will point your virtual host document root to your new application's `public/` directory.

To run the application in development, and if you not already have the web server running, you can run these command: 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it!

