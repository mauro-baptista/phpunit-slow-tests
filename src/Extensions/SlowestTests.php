<?php

namespace MauroBaptista\SlowTests\Extensions;

use MauroBaptista\SlowTests\Components;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;

class SlowestTests implements BeforeFirstTestHook, AfterTestHook, AfterLastTestHook
{
    /** @var array<string, float> array<$test,> */
    private array $tests = [];

    private array $sumUp = [
        'success' => 0,
        'warning' => 0,
        'danger' => 0,
    ];

    private Components $components;

    public function __construct(public int $show = 10, public array $threshold = [
        'success' => 0.1,
        'warning' => 1,
    ]) {
        $this->components = new Components();
    }

    public function executeBeforeFirstTest(): void
    {
        $this->tests = [];
    }

    public function executeAfterTest(string $test, float $time): void
    {
        $this->tests[$test] = $time;

        match (true) {
            $time <= $this->threshold['success'] => $this->sumUp['success']++,
            $time <= $this->threshold['warning'] => $this->sumUp['warning']++,
            default => $this->sumUp['danger']++,
        };
    }

    public function executeAfterLastTest(): void
    {
        arsort($this->tests);

        $slowestTests = array_slice($this->tests, 0, $this->show);

        array_walk($slowestTests, function (&$value, $key) {
            $status = match (true) {
                $value <= $this->threshold['success'] => '💚',
                $value <= $this->threshold['warning'] => '💛',
                default => '💔',
            };

            $seconds = ($value <= 1) ? 'Less than one second' : $value;

            [$class, $test] = explode('::', $key);

            $value = [$class, $test, $seconds, $status];
        });

        $this->components->table(
            ['Class', 'Test', 'Time', 'Status'],
            $slowestTests,
        );

        $this->components->separator();
        $this->components->success("{$this->sumUp['success']} test(s) [Less than {$this->threshold['success']} second(s)");
        $this->components->warning("{$this->sumUp['warning']} test(s) [Less than {$this->threshold['warning']} second(s)");
        $this->components->error("{$this->sumUp['danger']} test(s) [More than {$this->threshold['warning']} second(s)");
    }
}
