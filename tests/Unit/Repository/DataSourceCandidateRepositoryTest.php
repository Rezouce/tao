<?php

namespace Tests\Unit\Repository;

use App\Candidate;
use App\DataSource\DataSource;
use App\DataSource\InMemoryDataSource;
use App\Repository\CandidateRepository;
use App\Repository\ModelNotFoundException;
use Illuminate\Support\Collection;
use Tests\RefreshCandidates;
use Tests\TestCase;

class DataSourceCandidateRepositoryTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_return_its_candidates()
    {
        $candidates = $this->createCandidates(5);

        $repository = new CandidateRepository($this->createDataSource($candidates));

        $this->assertEquals($candidates, $repository->all());
    }

    /** @test */
    public function it_can_return_paginated_candidates()
    {
        $candidates = $this->createCandidates(9);

        $repository = new CandidateRepository($this->createDataSource($candidates));

        $results = $repository->paginate(6, 2);

        $this->assertSame($candidates->slice(6, 2)->values()->all(), $results->items());
        $this->assertEquals(9, $results->total());
        $this->assertEquals(3, $results->currentPage());
        $this->assertEquals(2, $results->perPage());
    }

    /** @test */
    public function it_can_filter_the_candidates_by_their_name()
    {
        $expectedCandidates = $this->createCandidates(2, ['firstname' => 'Ronald'])
            ->merge($this->createCandidates(2, ['lastname' => 'Ronald']));
        $notExpectedCandidates = $this->createCandidates(10, ['firstname' => 'Something', 'lastname' => 'Else']);

        $repository = new CandidateRepository(
            $this->createDataSource($notExpectedCandidates->merge($expectedCandidates))
        );

        $this->assertSame($expectedCandidates->toArray(), $repository->filterByName('ronald')->all()->toArray());
    }

    /** @test */
    public function it_can_get_a_candidate_by_its_id()
    {
        /** @var Candidate $candidate */
        $candidate = $this->createCandidates();

        $repository = new CandidateRepository($this->createDataSource(collect([$candidate])));

        $this->assertSame($candidate, $repository->get($candidate->getId()));
    }

    /** @test */
    public function it_will_fail_when_trying_to_get__with_an_id__not_matching_any_candidate()
    {
        $repository = new CandidateRepository();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("There isn't any candidate with the id test.");

        $repository->get('test');
    }

    private function createDataSource(Collection $collection): DataSource
    {
        return new InMemoryDataSource($collection, Candidate::class);
    }
}
