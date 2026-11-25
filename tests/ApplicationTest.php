<?php

declare(strict_types=1);

namespace BrainGames\Tests;

use BrainGames\Application;
use BrainGames\Game\GameRegistry;
use BrainGames\Tests\Support\FakeIo;
use BrainGames\Tests\Support\FixedGame;
use PHPUnit\Framework\TestCase;

final class ApplicationTest extends TestCase
{
    public function testClosedInputExitsGracefully(): void
    {
        $io = new FakeIo(['Alex', 'yes']); // input ends after the first answer

        $code = (new Application($io, new GameRegistry(new FixedGame())))->runGame('fixed');

        self::assertSame(Application::EXIT_INTERRUPTED, $code);
        self::assertStringEndsWith('Bye!', $io->printed());
    }

    public function testMenuRunsChosenGameAndExits(): void
    {
        $io = new FakeIo(['Alex', 'abc', '1', 'yes', 'yes', 'yes', '0']);

        $code = (new Application($io, new GameRegistry(new FixedGame())))->runMenu();

        self::assertSame(Application::EXIT_OK, $code);
        self::assertStringContainsString("'abc' is not a valid option.", $io->printed());
        self::assertStringContainsString('Congratulations, Alex!', $io->printed());
        self::assertStringContainsString('Bye, Alex!', $io->printed());
    }

    public function testUnknownGameReturnsUsageError(): void
    {
        $io = new FakeIo([]);

        $code = (new Application($io, new GameRegistry(new FixedGame())))->runGame('chess');

        self::assertSame(Application::EXIT_USAGE, $code);
        self::assertSame("Unknown game 'chess'. Available: fixed", $io->output[0]);
    }
}
