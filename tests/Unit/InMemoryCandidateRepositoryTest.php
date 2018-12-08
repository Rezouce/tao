<?php

namespace Tests\Unit;

use App\Candidate;
use App\Repository\InMemoryCandidateRepository;
use App\Repository\ModelNotFoundException;
use Tests\RefreshCandidates;
use Tests\TestCase;

class InMemoryCandidateRepositoryTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_return_its_candidates()
    {
        $candidates = $this->createCandidates(5);

        $repository = new InMemoryCandidateRepository($candidates);

        $this->assertEquals($candidates, $repository->all());
    }

    /** @test */
    public function it_can_add_candidates_to_the_repository()
    {
        $candidates = $this->createCandidates(5);

        $repository = new InMemoryCandidateRepository();

        foreach ($candidates as $candidate) {
            $repository->add($candidate);
        }

        $this->assertSame($candidates->toArray(), $repository->all()->toArray());
    }

    /** @test */
    public function it_will_fail_if_trying_to_add_something_else_than_a_candidate()
    {
        $repository = new InMemoryCandidateRepository();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Received a stdClass instead of a App\Candidate.');

        $repository->add(new \stdClass());
    }

    /** @test */
    public function it_can_return_paginated_candidates()
    {
        $candidates = $this->createCandidates(9);

        $repository = new InMemoryCandidateRepository($candidates);

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

        $repository = new InMemoryCandidateRepository(
            $this->createCandidates(10, ['firstname' => 'Something', 'lastname' => 'Else'])
                ->merge($expectedCandidates)
        );

        $this->assertSame($expectedCandidates->toArray(), $repository->filterByName('ronald')->all()->toArray());
    }

    /** @test */
    public function it_can_get_a_candidate_by_its_id()
    {
        /** @var Candidate $candidate */
        $candidate = $this->createCandidates();

        $repository = new InMemoryCandidateRepository(collect([$candidate]));

        $this->assertSame($candidate, $repository->get($candidate->getId()));
    }

    /** @test */
    public function it_will_fail_when_trying_to_get__with_an_id__not_matching_any_candidate()
    {
        $repository = new InMemoryCandidateRepository();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage("There isn't any candidate with the id test.");

        $repository->get('test');
    }
}
