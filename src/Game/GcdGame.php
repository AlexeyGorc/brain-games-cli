<?php

declare(strict_types=1);

namespace BrainGames\Game;

use Random\Randomizer;

final class GcdGame implements GameInterface
{
    public function __construct(private readonly Randomizer $random = new Randomizer())
    {
    }

    public function getId(): string
    {
        return 'gcd';
    }

    public function getTitle(): string
    {
        return 'Greatest common divisor';
    }

    public function getRules(): string
    {
        return 'Find the greatest common divisor of given numbers.';
    }

    public function generateRound(): Round
    {
        $a = $this->random->getInt(1, 100);
        $b = $this->random->getInt(1, 100);

        return new Round("{$a} {$b}", (string) self::gcd($a, $b));
    }

    public static function gcd(int $a, int $b): int
    {
        $a = abs($a);
        $b = abs($b);

        while ($b !== 0) {
            [$a, $b] = [$b, $a % $b];
        }

        return $a;
    }
}
