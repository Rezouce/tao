<?php

namespace Tests\Unit;

use App\Candidate;
use PHPUnit\Framework\TestCase;

class CandidateTest extends TestCase
{
    /** @test */
    public function it_can_return_a_candidate_as_an_array()
    {
        $candidate = new Candidate([
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
}
