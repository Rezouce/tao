<?php

namespace App\DataSource;

use Illuminate\Support\Facades\File;

class JsonDataSource implements DataSource
{
    private $models;

    private $modelClass;

    public function __construct(string $filePath, string $modelClass)
    {
        $data = File::get($filePath);

        $this->modelClass = $modelClass;

        $this->hydrate(json_decode($data, true));
    }

    private function hydrate(array $data)
    {
        $this->models = [];
        $modelClass = $this->modelClass;

        foreach ($data as $modelData) {
            $this->models[] = new $modelClass($modelData);
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
