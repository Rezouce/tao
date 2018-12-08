<?php

namespace App\Repository;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CandidateRepositoryInterface
{
    public function all(): Collection;

    public function paginate(int $offset, int $limit): LengthAwarePaginator;
}
