<?php

namespace App\DataSource;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

class CsvDataSource implements DataSource
{
    private $models;

    private $modelClass;

    /**
     * @throws FileNotFoundException
     */
    public function __construct(string $filePath, string $modelClass)
    {
        $data = File::get($filePath);

        $this->modelClass = $modelClass;

        $this->hydrate($data);
    }

    private function hydrate(string $data)
    {
        $this->models = [];
        $modelClass = $this->modelClass;

        $resource = fopen('php://temp', 'rb+');
        fwrite($resource, $data);
        rewind($resource);

        $keys = fgetcsv($resource);

        while (false !== $modelData = fgetcsv($resource)) {
            $this->models[] = new $modelClass(array_combine($keys, $modelData));
        }
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->models);
    }

    public function count()
    {
        return count($this->models);
    }

    public function filter(callable $filter): DataSource
    {
        return new InMemoryDataSource(collect($this->models)->filter($filter), $this->modelClass);
    }
}
