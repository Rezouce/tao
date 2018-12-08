# Install dependencies

The dependencies are managed through composer and can be installed using the command `composer install`.

# Run the tests

To run the tests use the command `vendor/bin/phpunit`.

# Routes

You can find the routes in the [api.php](/routes/api.php) file.

The `[GET]/candidates` endpoint can accept the parameters `offset`, `limit` and `name`.

# Data source

The data source used by the application is defined in the AppServiceProvider boot method.
It uses the Json file testtakers.json (located in /resources) by default.

You can use the CSV data source by replacing this:
```php
<?php
$container->singleton(CandidateRepository::class, function () {
    return new CandidateRepository(
        new JsonDataSource(resource_path() . '/testtakers.json', Candidate::class)
    );
});
```
By this:
```php
<?php
$container->singleton(CandidateRepository::class, function () {
    return new CandidateRepository(
        new CsvDataSource(resource_path() . '/testtakers.csv', Candidate::class)
    );
});
```
