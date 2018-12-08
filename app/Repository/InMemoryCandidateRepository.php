<?php

namespace App\Repository;

use App\Candidate;
use App\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Collection;

class InMemoryCandidateRepository implements CandidateRepositoryInterface
{
    private $candidates;

    public function __construct(Collection $candidates = null)
    {
        $this->candidates = collect();

        foreach ($candidates ?: [] as $candidate) {
            $this->add($candidate);
        }
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

    public function all(): Collection
    {
        return $this->candidates;
    }

    public function paginate(int $offset, int $limit): LengthAwarePaginatorContract
    {
        return new Paginator(
            $this->candidates->slice($offset, $limit)->values(),
            count($this->candidates),
            $limit,
            ceil($offset / $limit)
        );
    }
}
