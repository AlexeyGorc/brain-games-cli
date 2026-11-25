<?php

declare(strict_types=1);

namespace BrainGames\Game;

final readonly class Round
{
    public function __construct(
        public string $question,
        public string $correctAnswer,
    ) {
    }
}
