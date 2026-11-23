<?php

declare(strict_types=1);

namespace BrainGames\Io;

interface IoInterface
{
    public function line(string $text = ''): void;

    /** @throws InputClosedException when the user closes input (Ctrl+D) */
    public function ask(string $question): string;
}
