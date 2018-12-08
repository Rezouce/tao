<?php

namespace App\DataSource;

interface DataSource extends \IteratorAggregate, \Countable
{
    public function filter(callable $filter): DataSource;
}
