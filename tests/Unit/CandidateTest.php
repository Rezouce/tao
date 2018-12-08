<?php

namespace Tests\Unit;

use Tests\RefreshCandidates;
use Tests\TestCase;

class CandidateTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_return_a_candidate_as_an_array()
    {
        $candidate = $this->createCandidates(1, [
            'login' => 'fosterabigail',
            'password' => 'P7ghvUQJNr6myOEP',
            'title' => 'mrs',
            'lastname' => 'foster',
            'firstname' => 'abigail',
            'gender' => 'female',
            'email' => 'abigail.foster60@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
            'address' => '1851 saddle dr anna 69319'
        ]);

        $this->assertEquals([
            'id' => 'fosterabigail',
            'login' => 'fosterabigail',
            'password' => 'P7ghvUQJNr6myOEP',
            'title' => 'mrs',
            'lastname' => 'foster',
            'firstname' => 'abigail',
            'gender' => 'female',
            'email' => 'abigail.foster60@example.com',
            'picture' => 'https://api.randomuser.me/0.2/portraits/women/10.jpg',
            'address' => '1851 saddle dr anna 69319'
        ], $candidate->toArray());
    }

    /** @test */
    public function it_can_check_if_the_candidate_firstname_or_lastname_contains_the_searched_string()
    {
        $candidate = $this->createCandidates(1, [
            'lastname' => 'foster',
            'firstname' => 'abigail',
        ]);

        $this->assertTrue($candidate->hasNameContaining('foster'));
        $this->assertTrue($candidate->hasNameContaining('abigail'));
        $this->assertTrue($candidate->hasNameContaining('FO'));
        $this->assertTrue($candidate->hasNameContaining('GAI'));
        $this->assertFalse($candidate->hasNameContaining('something else'));
    }
}
