<?php

declare(strict_types=1);

namespace BrainGames\Game;

use InvalidArgumentException;
use Random\Randomizer;

final class CalcGame implements GameInterface
{
    private const OPERATORS = ['+', '-', '*'];

    public function __construct(private readonly Randomizer $random = new Randomizer())
    {
    }

    public function getId(): string
    {
        return 'calc';
    }

    public function getTitle(): string
    {
        return 'Calculator';
    }

    public function getRules(): string
    {
        return 'What is the result of the expression?';
    }

    public function generateRound(): Round
    {
        $left = $this->random->getInt(1, 50);
        $right = $this->random->getInt(1, 50);
        $operator = self::OPERATORS[$this->random->getInt(0, count(self::OPERATORS) - 1)];

        return new Round(
            "{$left} {$operator} {$right}",
            (string)self::calculate($left, $right, $operator),
        );
    }

    public static function calculate(int $left, int $right, string $operator): int
    {
        return match ($operator) {
            '+' => $left + $right,
            '-' => $left - $right,
            '*' => $left * $right,
            default => throw new InvalidArgumentException("Unknown operator: {$operator}"),
        };
    }
}
