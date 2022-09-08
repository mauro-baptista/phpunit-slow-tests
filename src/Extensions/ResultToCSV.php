<?php

namespace MauroBaptista\SlowTests\Extensions;

use MauroBaptista\SlowTests\Components;
use PHPUnit\Runner\AfterLastTestHook;
use PHPUnit\Runner\AfterTestHook;
use PHPUnit\Runner\BeforeFirstTestHook;

class ResultToCSV implements BeforeFirstTestHook, AfterTestHook, AfterLastTestHook
{
    private $handle;
    private Components $components;

    public function __construct(public string $file = 'result.csv')
    {
        $this->components = new Components();
    }

    private function getFile(): string
    {
        return './' . trim($this->file, '/');
    }

    public function executeBeforeFirstTest(): void
    {
        $file = $this->getFile();

        if (file_exists($file)) {
            unlink($file);
        }

        touch($file);

        $this->handle = fopen($this->getFile(), "a");

        if (! is_resource($this->handle)) {
            $this->components->error("Couldn't open file <i>$file</i>", [
                'You added the report inside a folder that do not exist',
                'You have no permission to create/write the file',
            ]);

            return;
        }

        fputcsv($this->handle, ['datetime', 'class', 'method', 'duration']);
    }

    public function executeAfterTest(string $test, float $time): void
    {
        [$class, $method] = explode('::', $test);

        is_resource($this->handle) && fputcsv($this->handle, [date('Y-m-d H:i:s'), $class, $method, $time]);
    }

    public function executeAfterLastTest(): void
    {
        is_resource($this->handle) && fclose($this->handle);

        $this->components->newLine(2);
        $this->components->success('[ResultToCSV] Report Generated');
        $this->components->info('File saved at: ' . $this->getFile());
        $this->components->newLine(1);
    }
}
