<?php

namespace Tests;

use App\Candidate;
use App\Repository\CandidateRepositoryInterface;
use App\Repository\InMemoryCandidateRepository;
use Faker\Generator;
use Illuminate\Container\Container;

trait RefreshCandidates
{
    public function refreshCandidates(): void
    {
        /** @var Container $container */
        $container = app();
        $container->singleton(CandidateRepositoryInterface::class, function () {
            return new InMemoryCandidateRepository();
        });
    }

    public function createCandidates(int $numberOfCandidates)
    {
        /** @var Generator $faker */
        $faker = app(Generator::class);
        /** @var InMemoryCandidateRepository $repository */
        $repository = app(CandidateRepositoryInterface::class);

        $candidates = collect();

        for ($i = 0; $i < $numberOfCandidates; ++$i) {
            $candidate = new Candidate([
                'login' => $faker->userName,
                'password' => $faker->password,
                'title' => $faker->title,
                'lastname' => $faker->lastName,
                'firstname' => $faker->firstName,
                'gender' => $faker->randomElement(['male', 'female']),
                'email' => $faker->email,
                'picture' => $faker->imageUrl(),
                'address' => $faker->address,
            ]);

            $candidates->push($candidate);

            $repository->add($candidate);
        }

        return $numberOfCandidates === 1 ? $candidates->first() : $candidates;
    }
}
