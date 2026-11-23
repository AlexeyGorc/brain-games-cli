<?php

declare(strict_types=1);

namespace BrainGames\Game;

use Random\Randomizer;

final class ProgressionGame implements GameInterface
{
    private const HIDDEN = '..';

    public function __construct(private readonly Randomizer $random = new Randomizer())
    {
    }

    public function getId(): string
    {
        return 'progression';
    }

    public function getTitle(): string
    {
        return 'Arithmetic progression';
    }

    public function getRules(): string
    {
        return 'What number is missing in the progression?';
    }

    public function generateRound(): Round
    {
        $length = $this->random->getInt(5, 10);
        $progression = self::build(
            $this->random->getInt(1, 20),
            $this->random->getInt(1, 10),
            $length,
        );

        $hiddenIndex = $this->random->getInt(0, $length - 1);
        $answer = (string) $progression[$hiddenIndex];

        $shown = array_map('strval', $progression);
        $shown[$hiddenIndex] = self::HIDDEN;

        return new Round(implode(' ', $shown), $answer);
    }

    /** @return list<int> */
    public static function build(int $start, int $step, int $length): array
    {
        return array_map(
            static fn (int $i): int => $start + $step * $i,
            range(0, $length - 1),
        );
    }
}
