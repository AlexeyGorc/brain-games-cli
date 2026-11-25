<?php

declare(strict_types=1);

namespace BrainGames\Tests\Game;

use BrainGames\Game\CalcGame;
use BrainGames\Game\EvenGame;
use BrainGames\Game\GcdGame;
use BrainGames\Game\PrimeGame;
use BrainGames\Game\ProgressionGame;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class MathTest extends TestCase
{
    public function testIsEven(): void
    {
        self::assertTrue(EvenGame::isEven(0));
        self::assertTrue(EvenGame::isEven(42));
        self::assertFalse(EvenGame::isEven(7));
    }

    /** @return iterable<string, array{int, int, string, int}> */
    public static function calcCases(): iterable
    {
        yield 'plus' => [2, 3, '+', 5];
        yield 'minus to negative' => [3, 10, '-', -7];
        yield 'multiply' => [6, 7, '*', 42];
    }

    #[DataProvider('calcCases')]
    public function testCalculate(int $left, int $right, string $operator, int $expected): void
    {
        self::assertSame($expected, CalcGame::calculate($left, $right, $operator));
    }

    public function testUnknownOperatorThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);

        CalcGame::calculate(1, 2, '/');
    }

    /** @return iterable<array{int, int, int}> */
    public static function gcdCases(): iterable
    {
        yield [12, 18, 6];
        yield [17, 5, 1];
        yield [100, 100, 100];
        yield [0, 5, 5];
        yield [0, 0, 0];
    }

    #[DataProvider('gcdCases')]
    public function testGcd(int $a, int $b, int $expected): void
    {
        self::assertSame($expected, GcdGame::gcd($a, $b));
    }

    /** @return iterable<array{int, bool}> */
    public static function primeCases(): iterable
    {
        foreach ([2, 3, 5, 7, 11, 97] as $n) {
            yield [$n, true];
        }
        foreach ([-7, 0, 1, 4, 9, 25, 100] as $n) {
            yield [$n, false];
        }
    }

    #[DataProvider('primeCases')]
    public function testIsPrime(int $number, bool $expected): void
    {
        self::assertSame($expected, PrimeGame::isPrime($number));
    }

    public function testProgressionHasRequestedLength(): void
    {
        self::assertSame([1, 3, 5, 7, 9], ProgressionGame::build(1, 2, 5));
    }
}
