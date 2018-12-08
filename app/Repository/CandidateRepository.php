<?php

namespace App\Repository;

use App\Candidate;
use App\DataSource\DataSource;
use App\DataSource\InMemoryDataSource;
use App\Pagination\Paginator;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Support\Collection;

class CandidateRepository
{
    /** @var DataSource|Candidate[] */
    private $candidates;

    public function __construct(DataSource $candidates = null)
    {
        $this->candidates = $candidates ?: new InMemoryDataSource(null, Candidate::class);
    }

    public function all(): Collection
    {
        $candidates = [];

        foreach ($this->candidates as $candidate) {
            $candidates[] = $candidate;
        }

        return collect($candidates);
    }

    public function paginate(int $offset, int $limit): LengthAwarePaginatorContract
    {
        $candidates = [];

        foreach ($this->candidates as $key => $candidate) {
            if ($key >= $offset) {
                $candidates[] = $candidate;
            }

            if ($key +1 >= $offset + $limit) {
                break;
            }
        }

        return new Paginator(
            collect($candidates),
            count($this->candidates),
            $limit,
            ceil($offset / $limit)
        );
    }

    public function filterByName(string $name): CandidateRepository
    {
        return new static(
            $this->candidates->filter(function (Candidate $candidate) use ($name) {
                return $candidate->hasNameContaining($name);
            })
        );
    }

    /**
     * @throws ModelNotFoundException
     */
    public function get(string $id): Candidate
    {
        foreach ($this->candidates as $candidate) {
            if ($candidate->getId() === $id) {
                return $candidate;
            }
        }

        throw new ModelNotFoundException(sprintf("There isn't any candidate with the id %s.", $id));
    }
}
