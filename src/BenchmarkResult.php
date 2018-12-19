<?php

namespace rkistaps\benchmark;

use Juration\Juration;

class BenchmarkResult
{
    /** @var float */
    public $startTime = 0;

    /** @var float */
    public $endTime = 0;

    /** @var float */
    public $executionTime = 0;

    /** @var int */
    public $memoryPeak = 0;

    /**
     * @return string
     * @throws \Juration\Exception
     */
    public function getReadableTime(): string
    {
        return Juration::stringify($this->executionTime);
    }

    /**
     * @return string
     */
    public function getReadableMemoryPeak(): string
    {
        $i = (int)floor(log($this->executionTime, 1024));

        return round($this->executionTime / pow(1024, $i), [0,0,2,2,3][$i]).['B','kB','MB','GB','TB'][$i];
    }
}
