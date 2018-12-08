<?php

namespace App\Http\Controllers;

use App\Repository\CandidateRepositoryInterface;

class CandidateController extends Controller
{
    public function index(CandidateRepositoryInterface $repository)
    {
        if (request('name')) {
            $repository = $repository->filterByName(request('name'));
        }

        return response(
            $repository->paginate(request('offset', 0), request('limit', 10))
            , 200
        );
    }
}
