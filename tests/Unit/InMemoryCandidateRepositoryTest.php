<?php

namespace Tests\Unit;

use App\Repository\InMemoryCandidateRepository;
use Tests\RefreshCandidates;
use Tests\TestCase;

class InMemoryCandidateRepositoryTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_add_candidates_to_the_repository()
    {
        $candidates = $this->createCandidates(5);

        $repository = new InMemoryCandidateRepository();

        foreach ($candidates as $candidate) {
            $repository->add($candidate);
        }

        $this->assertEquals($candidates, $repository->findAll());
    }

    /** @test */
    public function it_will_fail_if_trying_to_add_something_else_than_a_candidate()
    {
        $repository = new InMemoryCandidateRepository();

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('Received a stdClass instead of a App\Candidate.');

        $repository->add(new \stdClass());
    }
}
