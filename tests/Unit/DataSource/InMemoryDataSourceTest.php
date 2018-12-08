<?php

namespace Tests\Unit\DataSource;

use App\Candidate;
use App\DataSource\InMemoryDataSource;
use Illuminate\Support\Collection;
use Tests\RefreshCandidates;
use Tests\TestCase;

class InMemoryDataSourceTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_convert_a_collection_of_candidates_to_a_data_source_of_candidates()
    {
        $candidates = $this->createCandidates(2);

        $dataSource = new InMemoryDataSource($candidates, Candidate::class);

        $this->assertCount(2, $dataSource);
        $this->assertCandidates($candidates, $dataSource);
    }

    private function assertCandidates(Collection $expected, InMemoryDataSource $dataSource): void
    {
        foreach ($dataSource as $key => $candidate) {
            $this->assertEquals($expected->get($key), $candidate);
        }
    }
}
