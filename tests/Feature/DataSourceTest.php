<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\TestCase;

class DataSourceTest extends TestCase
{
    /** @test */
    public function it_uses_the_json_data_source_by_default()
    {
        $response = $this->getJson('/candidates');

        $response->assertStatus(200);
        $response->assertJson(json_decode(File::get(resource_path() . '/testtakers.json'), true));
    }
}
