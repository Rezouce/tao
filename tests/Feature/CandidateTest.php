<?php

namespace Tests\Feature;

use Tests\RefreshCandidates;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_return_a_list_of_candidates()
    {
        $candidates = $this->createCandidates(5);

        $response = $this->getJson('/candidates');

        $response->assertStatus(200);
        $response->assertJson($candidates->toArray());
    }

    /** @test */
    public function it_can_return_a_subset_of_the_list_of_candidates()
    {
        $candidates = $this->createCandidates(5);

        $response = $this->getJson('/candidates?offset=1&limit=2');

        $response->assertStatus(200);
        $response->assertJson(array_slice($candidates->toArray(), 1, 2));
    }

    /** @test */
    public function it_can_filter_the_candidates_by_their_name()
    {
        $candidatesWithMatchingFirstname = $this->createCandidates(2, ['firstname' => 'Ronald']);
        $candidatesWithMatchingLastname = $this->createCandidates(2, ['lastname' => 'Ronald']);
        $this->createCandidates(10, ['firstname' => 'Something', 'lastname' => 'Else']);

        $response = $this->getJson('/candidates?name=ronald');

        $response->assertStatus(200);
        $response->assertExactJson($candidatesWithMatchingFirstname->merge($candidatesWithMatchingLastname)->toArray());
    }
}
