<?php

namespace tests;

use PHPUnit\Framework\TestCase;

abstract class TestBase extends TestCase
{
    /**
     * @param float $seconds
     */
    public function sleep(float $seconds)
    {
        usleep($seconds * 1000000);
    }
}