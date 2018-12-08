<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[RefreshCandidates::class])) {
            $this->refreshCandidates();
        }

        return $uses;
    }
}
