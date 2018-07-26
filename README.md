# Modus Create API

## Requirements

PHP 7.0 or greater

## Install the Application

Run this command from the directory in which you want to install this API.

    php composer.phar install [my-app-name]

Replace `[my-app-name]` with the desired directory name for your new application. You'll want to:

* Ensure `logs/` is web writable.

The above command will point your virtual host document root to your new application's `public/` directory.

To run the application in development, and if you not already have the web server running, you can run these command: 

	cd [my-app-name]
	php composer.phar start

Run this command in the application directory to run the test suite

	php composer.phar test

That's it!

