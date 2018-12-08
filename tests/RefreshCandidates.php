<?php

namespace Tests;

use App\Candidate;
use App\DataSource\InMemoryDataSource;
use App\Repository\CandidateRepository;
use Faker\Generator;
use Illuminate\Container\Container;

trait RefreshCandidates
{
    /** @var InMemoryDataSource */
    private $dataSource;

    public function refreshCandidates(): void
    {
        $this->dataSource = new InMemoryDataSource(null, Candidate::class);

        /** @var Container $container */
        $container = app();
        $container->singleton(CandidateRepository::class, function () {
            return new CandidateRepository($this->dataSource);
        });
    }

    public function createCandidates(int $numberOfCandidates = 1, array $data = [])
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);

        $candidates = collect();

        for ($i = 0; $i < $numberOfCandidates; ++$i) {
            $candidate = new Candidate(array_merge([
                'login' => $faker->userName,
                'password' => $faker->password,
                'title' => $faker->title,
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'gender' => $faker->randomElement(['male', 'female']),
                'email' => $faker->email,
                'picture' => $faker->imageUrl(),
                'address' => $faker->address,
            ], $data));

            $candidates->push($candidate);

            $this->dataSource->add($candidate);
        }

        return $numberOfCandidates === 1 ? $candidates->first() : $candidates;
    }
}
