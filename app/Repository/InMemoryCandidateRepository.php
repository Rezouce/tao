<?php

namespace App\Repository;

use App\Candidate;
use Illuminate\Support\Collection;

class InMemoryCandidateRepository implements CandidateRepositoryInterface
{
    private $candidates;

    public function __construct()
    {
        $this->candidates = collect();
    }

    public function add($candidate): void
    {
        if (!$candidate instanceof Candidate) {
            throw new \LogicException(
                sprintf('Received a %s instead of a %s.', get_class($candidate), Candidate::class)
            );
        }

        $this->candidates->push($candidate);
    }

    public function findAll(): Collection
    {
        return $this->candidates;
    }
}
