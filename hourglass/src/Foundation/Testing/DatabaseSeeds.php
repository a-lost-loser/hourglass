<?php

namespace Hourglass\Foundation\Testing;

trait DatabaseSeeds
{
    protected $seeds = [
        'TestingDatabaseSeeder',
    ];

    protected function runDatabaseSeeds()
    {
        foreach ($this->seeds as $seed) {
            $this->seed($seed);
        }
    }
}