# Install dependencies

The dependencies are managed through composer and can be installed using the command `composer install`.

# Run the tests

To run the tests use the command `vendor/bin/phpunit`.

# Data source

The data source used by the application is defined in the AppServiceProvider boot method.
It uses the Json file testtakers.json (located in /resources) by default.
