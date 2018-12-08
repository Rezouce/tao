<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Repository\CandidateRepository;

class CandidateController extends Controller
{
    public function index(CandidateRepository $repository)
    {
        if (request('name')) {
            $repository = $repository->filterByName(request('name'));
        }

        return response($repository->paginate(request('offset', 0), request('limit', 100)), 200);
    }

    public function show(Candidate $candidate)
    {
        return response($candidate, 200);
    }
}
