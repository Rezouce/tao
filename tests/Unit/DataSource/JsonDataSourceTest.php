<?php

namespace Tests\Unit\DataSource;

use App\Candidate;
use App\DataSource\JsonDataSource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Tests\RefreshCandidates;
use Tests\TestCase;

class JsonDataSourceTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_convert_a_json_file_to_a_data_source_of_candidates()
    {
        $candidates = $this->createCandidates(2);

        File::shouldReceive('get')
            ->with('myfile.json')
            ->andReturn(json_encode($candidates->toArray()));

        $dataSource = new JsonDataSource('myfile.json', Candidate::class);

        $this->assertCount(2, $dataSource);
        $this->assertCandidates($candidates, $dataSource);
    }

    private function assertCandidates(Collection $expected, JsonDataSource $dataSource): void
    {
        foreach ($dataSource as $key => $candidate) {
            $this->assertEquals($expected->get($key), $candidate);
        }
    }
}
