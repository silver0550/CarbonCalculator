<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\TestCase;

class CarbonCalculatorTest extends TestCase
{
    use RefreshDatabase;

    protected $project;

    public function setup(): void
    {

    }

    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
