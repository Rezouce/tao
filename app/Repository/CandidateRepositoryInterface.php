<?php

namespace App\Repository;

use Illuminate\Support\Collection;

interface CandidateRepositoryInterface
{
    public function findAll(): Collection;
}
