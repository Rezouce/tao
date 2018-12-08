<?php

namespace App\Http\Controllers;

use App\Repository\CandidateRepositoryInterface;

class CandidateController extends Controller
{
    public function index(CandidateRepositoryInterface $repository)
    {
        return response($repository->findAll(), 200);
    }
}
