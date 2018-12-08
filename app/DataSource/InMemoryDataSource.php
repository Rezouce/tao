<?php

namespace App\DataSource;

use Illuminate\Support\Collection;

class InMemoryDataSource implements DataSource
{
    private $models;

    private $modelClass;

    public function __construct(?Collection $models, string $modelClass)
    {
        $this->models = collect();
        $this->modelClass = $modelClass;

        foreach ($models ?: [] as $model) {
            $this->add($model);
        }
    }

    public function add($model): void
    {
        if (!$model instanceof $this->modelClass) {
            throw new \LogicException(
                sprintf('Received a %s instead of a %s.', get_class($model), $this->modelClass)
            );
        }

        $this->models->push($model);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->models->all());
    }

    public function count()
    {
        return count($this->models);
    }

    public function filter(callable $filter): DataSource
    {
        return new static($this->models->filter($filter), $this->modelClass);
    }
}
