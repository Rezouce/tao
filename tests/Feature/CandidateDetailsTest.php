<?php

namespace Tests\Feature;

use App\Candidate;
use Tests\RefreshCandidates;
use Tests\TestCase;

class CandidateDetailsTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_show_an_unique_user()
    {
        /** @var Candidate $candidate */
        $candidate = $this->createCandidates(1);

        $response = $this->getJson('/candidates/' . $candidate->getId());

        $response->assertStatus(200);
        $response->assertJson($candidate->toArray());
    }

    /** @test */
    public function it_will_return_a_404_if_the_user_cant_be_found()
    {
        $response = $this->getJson('/candidates/inexistant-id');

        $response->assertStatus(404);
        $response->assertJson(['message' => "There isn't any candidate with the id inexistant-id."]);
    }
}
