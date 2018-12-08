<?php

namespace App\Repository;

use App\Candidate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CandidateRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $offset, int $limit): LengthAwarePaginator;

    public function filterByName(string $name): CandidateRepositoryInterface;

    /**
     * @throws ModelNotFoundException
     */
    public function get(string $id): Candidate;
}
