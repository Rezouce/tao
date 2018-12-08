<?php

namespace App\Repository;

use Illuminate\Support\Collection;

class InMemoryCandidateRepository implements CandidateRepositoryInterface
{
    private $candidates;

    public function __construct(Collection $candidates)
    {
        $this->candidates = $candidates;
    }

    public function findAll(): Collection
    {
        return $this->candidates;
    }
}
