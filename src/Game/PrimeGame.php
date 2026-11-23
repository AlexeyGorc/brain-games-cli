<?php

declare(strict_types=1);

namespace BrainGames\Game;

use Random\Randomizer;

final class PrimeGame implements GameInterface
{
    public function __construct(private readonly Randomizer $random = new Randomizer())
    {
    }

    public function getId(): string
    {
        return 'prime';
    }

    public function getTitle(): string
    {
        return 'Prime number';
    }

    public function getRules(): string
    {
        return 'Answer "yes" if given number is prime. Otherwise answer  "no".';
    }

    public function generateRound(): Round
    {
        $number = $this->random->getInt(1, 100);

        return new Round((string) $number, self::isPrime($number) ? 'yes' : 'no');
    }

    public static function isPrime(int $number): bool
    {
        if ($number < 2) {
            return false;
        }

        for ($divisor = 2; $divisor * $divisor <= $number; $divisor++) {
            if ($number % $divisor === 0) {
                return false;
            }
        }

        return true;
    }
}
