<?php

namespace MauroBaptista\SlowTests;

use function Termwind\render;

class Components
{
    private function block(string $message): void
    {
        render(<<<"HTML"
            <div class="p-2">
                $message
            </div>
        HTML);
    }

    private function message(string $message, string $type, string $backgroundColor): string
    {
        return <<<"HTML"
            <div>
                <div class="px-1 bg-$backgroundColor-600">$type</div>
                <em class="ml-1">$message</em>
            </div>
        HTML;
    }

    public function error(string $message, array $reasons = []): void
    {
        $message = $this->message($message, 'Error', 'red');

        if (empty($reasons)) {
            $this->block($message);
        }

        $message .= '<BR>';
        $message .= '<div class="font-bold">Possible reasons:</div>';

        $list = array_reduce($reasons, function (?string $carry, string $reason) {
            return $carry . "<li>$reason</li>";
        });

        $message .= "<ul>$list</ul>";

        $this->block($message);
    }
}
