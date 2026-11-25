<?php

declare(strict_types=1);

namespace BrainGames\Tests\Support;

use BrainGames\Game\GameInterface;
use BrainGames\Game\Round;

final class FixedGame implements GameInterface
{
    public function __construct(private readonly string $answer = 'yes')
    {
    }

    public function getId(): string
    {
        return 'fixed';
    }

    public function getTitle(): string
    {
        return 'Fixed';
    }

    public function getRules(): string
    {
        return 'Always answer the same.';
    }

    public function generateRound(): Round
    {
        return new Round('?', $this->answer);
    }
}
