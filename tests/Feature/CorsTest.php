<?php

namespace Tests\Feature;

use Tests\TestCase;

class CorsTest extends TestCase
{
    /** @test */
    public function it_returns_cors_headers()
    {
        $response = $this->getJson('/candidates', ['Origin' => 'somewhere else']);

        $response->assertHeader('access-control-allow-origin', 'somewhere else');
    }
}
