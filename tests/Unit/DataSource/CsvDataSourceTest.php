<?php

namespace Tests\Unit\DataSource;

use App\Candidate;
use App\DataSource\CsvDataSource;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Tests\RefreshCandidates;
use Tests\TestCase;

class CsvDataSourceTest extends TestCase
{
    use RefreshCandidates;

    /** @test */
    public function it_can_convert_a_json_file_to_a_data_source_of_candidates()
    {
        $candidates = $this->createCandidates(2);

        File::shouldReceive('get')
            ->with('myfile.csv')
            ->andReturn($this->generateCsv($candidates));

        $dataSource = new CsvDataSource('myfile.csv', Candidate::class);

        $this->assertCount(2, $dataSource);
        $this->assertCandidates($candidates, $dataSource);
    }

    /** @test */
    public function it_will_fail_if_the_file_cant_be_found()
    {
        $this->expectException(FileNotFoundException::class);

        new CsvDataSource('myfile.csv', Candidate::class);
    }

    private function assertCandidates(Collection $expected, CsvDataSource $dataSource): void
    {
        foreach ($dataSource as $key => $candidate) {
            $this->assertEquals($expected->get($key), $candidate);
        }
    }

    function generateCsv(Collection $candidates) {
        $handle = fopen('php://temp', 'rb+');

        fputcsv($handle, array_keys($candidates->first()->toArray()));

        foreach ($candidates as $candidate) {
            fputcsv($handle, $candidate->toArray());
        }

        rewind($handle);

        $csv = '';

        while (!feof($handle)) {
            $csv .= fread($handle, 8192);
        }

        fclose($handle);
        return $csv;
    }
}
