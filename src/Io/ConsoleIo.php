<?php

declare(strict_types=1);

namespace BrainGames\Io;

use Exception;

use function cli\line;
use function cli\prompt;

final class ConsoleIo implements IoInterface
{
    public function line(string $text = ''): void
    {
        $text === '' ? line() : line('%s', $text);
    }

    public function ask(string $question): string
    {
        try {
            return (string) prompt($question, false, ': ');
        } catch (Exception $e) {
            throw new InputClosedException('Input closed', 0, $e);
        }
    }
}
