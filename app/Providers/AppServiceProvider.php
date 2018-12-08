<?php

namespace App\Providers;

use App\Candidate;
use App\DataSource\JsonDataSource;
use App\Repository\CandidateRepository;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /** @var Container $container */
        $container = app();

        $container->singleton(CandidateRepository::class, function () {
            return new CandidateRepository(
                new JsonDataSource(resource_path() . '/testtakers.json', Candidate::class)
            );
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
