<?php

declare(strict_types=1);

namespace BrainGames\Game;

use Random\Randomizer;

final class EvenGame implements GameInterface
{
    public function __construct(private readonly Randomizer $random = new Randomizer())
    {
    }

    public function getId(): string
    {
        return 'even';
    }

    public function getTitle(): string
    {
        return 'Even number';
    }

    public function getRules(): string
    {
        return 'Answer "yes" if the number is even, otherwise answer "no".';
    }

    public function generateRound(): Round
    {
        $number = $this->random->getInt(1, 100);

        return new Round((string) $number, self::isEven($number) ? 'yes' : 'no');
    }

    public static function isEven(int $number): bool
    {
        return $number % 2 === 0;
    }
}
