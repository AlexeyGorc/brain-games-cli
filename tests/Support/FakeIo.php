<?php

declare(strict_types=1);

namespace BrainGames\Tests\Support;

use BrainGames\Io\InputClosedException;
use BrainGames\Io\IoInterface;

final class FakeIo implements IoInterface
{
    /** @var list<string> */
    public array $output = [];

    /** @param list<string> $answers */
    public function __construct(private array $answers)
    {
    }

    public function line(string $text = ''): void
    {
        $this->output[] = $text;
    }

    public function ask(string $question): string
    {
        $this->output[] = "{$question}: ";

        return array_shift($this->answers) ?? throw new InputClosedException();
    }

    public function printed(): string
    {
        return implode("\n", $this->output);
    }
}
