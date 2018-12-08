<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_the_api_calls_are_working()
    {
        $response = $this->get('/example');

        $response->assertStatus(200);
    }
}
