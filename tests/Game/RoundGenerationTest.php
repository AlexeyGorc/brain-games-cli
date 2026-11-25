<?php

declare(strict_types=1);

namespace BrainGames\Tests\Game;

use BrainGames\Game\CalcGame;
use BrainGames\Game\EvenGame;
use BrainGames\Game\GameInterface;
use BrainGames\Game\GcdGame;
use BrainGames\Game\PrimeGame;
use BrainGames\Game\ProgressionGame;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Random\Engine\Mt19937;
use Random\Randomizer;

/** Generates many rounds with a fixed seed and checks each answer independently. */
final class RoundGenerationTest extends TestCase
{
    private const SAMPLES = 200;

    /** @return iterable<string, array{GameInterface, callable(string): string}> */
    public static function games(): iterable
    {
        $seeded = static fn (): Randomizer => new Randomizer(new Mt19937(42));

        yield 'even' => [
            new EvenGame($seeded()),
            static fn (string $q): string => (int) $q % 2 === 0 ? 'yes' : 'no',
        ];
        yield 'calc' => [new CalcGame($seeded()), static function (string $q): string {
            [$a, $op, $b] = explode(' ', $q);

            return (string) CalcGame::calculate((int) $a, (int) $b, $op);
        }];
        yield 'gcd' => [new GcdGame($seeded()), static function (string $q): string {
            [$a, $b] = array_map('intval', explode(' ', $q));
            for ($d = min($a, $b); $d > 1; $d--) {
                if ($a % $d === 0 && $b % $d === 0) {
                    return (string) $d;
                }
            }

            return '1';
        }];
        yield 'prime' => [new PrimeGame($seeded()), static function (string $q): string {
            $n = (int) $q;
            $divisors = array_filter(range(1, $n), static fn (int $d): bool => $n % $d === 0);

            return count($divisors) === 2 ? 'yes' : 'no';
        }];
    }

    /** @param callable(string): string $oracle */
    #[DataProvider('games')]
    public function testAnswerMatchesIndependentOracle(GameInterface $game, callable $oracle): void
    {
        for ($i = 0; $i < self::SAMPLES; $i++) {
            $round = $game->generateRound();
            self::assertSame(
                $oracle($round->question),
                $round->correctAnswer,
                "Question: {$round->question}",
            );
        }
    }

    public function testProgressionRound(): void
    {
        $game = new ProgressionGame(new Randomizer(new Mt19937(42)));

        for ($i = 0; $i < self::SAMPLES; $i++) {
            $round = $game->generateRound();
            $items = explode(' ', $round->question);

            self::assertGreaterThanOrEqual(5, count($items));
            self::assertLessThanOrEqual(10, count($items));
            self::assertCount(1, array_keys($items, '..', true));

            $restored = array_map(
                static fn (string $item): int => (int) ($item === '..' ? $round->correctAnswer : $item),
                $items,
            );
            $step = $restored[1] - $restored[0];
            foreach (array_keys($restored) as $k) {
                self::assertSame($restored[0] + $step * $k, $restored[$k]);
            }
        }
    }
}
