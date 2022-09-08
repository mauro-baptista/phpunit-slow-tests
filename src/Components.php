<?php

namespace MauroBaptista\SlowTests;

use function Termwind\render;

class Components
{
    private function block(string $message): void
    {
        render(<<<"HTML"
            <div class="px-2">
                $message
            </div>
        HTML);
    }

    private function message(string $message, string $type, string $backgroundColor): string
    {
        return <<<"HTML"
            <div>
                <div class="px-1 bg-$backgroundColor-600 w-11 text-center uppercase">$type</div>
                <em class="ml-1">$message</em>
            </div>
        HTML;
    }

    public function separator(): void
    {
        render('<HR>');
    }

    public function newLine(int $lines = 1): void
    {
        $this->block(str_repeat('<BR>', $lines));
    }

    public function success(string $message): void
    {
        $this->block($this->message($message, 'Success', 'green'));
    }

    public function warning(string $message): void
    {
        $this->block($this->message($message, 'Warning', 'yellow'));
    }

    public function info(string $message): void
    {
        $this->block($this->message($message, 'INFO', 'blue'));
    }

    public function error(string $message, array $reasons = []): void
    {
        $message = $this->message($message, 'Error', 'red');

        if (empty($reasons)) {
            $this->block($message);

            return;
        }

        $message .= '<BR>';
        $message .= '<div class="font-bold">Possible reasons:</div>';

        $list = array_reduce(
            $reasons,
            fn (?string $carry, string $reason) => $carry . "<li>$reason</li>"
        );

        $message .= "<ul>$list</ul>";

        $this->block($message);
    }

    public function table(array $header, array $data): void
    {
        $message = '<table><thead><tr>';
        $message .= array_reduce(
            $header,
            fn (?string $carry, string $column) => $carry . "<th>$column</th>"
        );
        $message .= '</tr></thead>';

        foreach ($data as $row) {
            $message .= '<tr>' . array_reduce(
                $row,
                fn (?string $carry, string $column) => $carry . "<td>$column</td>"
            ) . '<tr>';
        }

        $message .= '</thead>';

        $this->block($message);
    }
}
