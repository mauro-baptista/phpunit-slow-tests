<?php

namespace MauroBaptista\SlowTests\Extensions;

use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;

class SlowestTests implements BeforeFirstTestHook, AfterTestHook, AfterLastTestHook
{
    /** @var array<string, float> array<$test,> */
    private array $tests = [];

    public function __construct(public int $show = 10)
    {
    }

    public function executeBeforeFirstTest(): void
    {
        $this->tests = [];
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->tests[$test] = $time;
    }

    public function executeAfterLastTest(): void
    {
        arsort($this->tests);

        $slowestTests = array_slice($this->tests, 0, $this->show);

        fwrite(STDERR, print_r($slowestTests, true));
    }
}
