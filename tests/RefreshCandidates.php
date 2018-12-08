<?php

namespace Tests;

use App\Repository\CandidateRepositoryInterface;
use App\Repository\InMemoryCandidateRepository;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;

trait RefreshCandidates
{
    public function refreshCandidates(): void
    {
        /** @var Container $container */
        $container = app();
        $container->bind(CandidateRepositoryInterface::class, function () {
            return new InMemoryCandidateRepository($this->getCandidates());
        });
    }

    public function getCandidates(): Collection
    {
        return collect($this->getCandidatesDataAsArray());
    }

    public function getCandidatesDataAsArray(): array
    {
        return json_decode('[
          {
            "login":"fosterabigail",
            "password":"P7ghvUQJNr6myOEP",
            "title":"mrs",
            "lastname":"foster",
            "firstname":"abigail",
            "gender":"female",
            "email":"abigail.foster60@example.com",
            "picture":"https://api.randomuser.me/0.2/portraits/women/10.jpg",
            "address":"1851 saddle dr anna 69319"
          },
          {
            "login":"grahamallison",
            "password":"LT9FaWRD7J7gS9Dw",
            "title":"ms",
            "lastname":"graham",
            "firstname":"allison",
            "gender":"female",
            "email":"allison.graham70@example.com",
            "picture":"https://api.randomuser.me/0.2/portraits/women/35.jpg",
            "address":"6697 rolling green rd colorado springs 56306"
          },
          {
            "login":"clarksusan",
            "password":"ejWpJUUDQQ8BKpZm",
            "title":"miss",
            "lastname":"clark",
            "firstname":"susan",
            "gender":"female",
            "email":"susan.clark11@example.com",
            "picture":"https://api.randomuser.me/0.2/portraits/women/33.jpg",
            "address":"3627 groveland terrace ennis 70832"
          }
        ]', true);
    }
}
