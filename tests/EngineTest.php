<?php

declare(strict_types=1);

namespace BrainGames\Tests;

use BrainGames\Engine;
use BrainGames\Tests\Support\FakeIo;
use BrainGames\Tests\Support\FixedGame;
use PHPUnit\Framework\TestCase;

final class EngineTest extends TestCase
{
    public function testWinsAfterThreeCorrectAnswers(): void
    {
        $io = new FakeIo(['yes', 'yes', 'yes']);

        $won = (new Engine($io))->play(new FixedGame(), 'Alex');

        self::assertTrue($won);
        self::assertStringContainsString('Congratulations, Alex!', $io->printed());
    }

    public function testStopOnFirstWrongAnswer(): void
    {
        $io = new FakeIo(['yes', 'no', 'yes']);

        $won = (new Engine($io))->play(new FixedGame(), 'Alex');

        self::assertFalse($won);
        self::assertStringContainsString("'no' is wrong answer", $io->printed());
        self::assertStringNotContainsString('Congratulations', $io->printed());
    }

    public function testAnswerIsCaseAndSpaceInsensitive(): void
    {
        $io = new FakeIo(['YES', ' Yes ', 'yEs']);

        self::assertTrue((new Engine($io))->play(new FixedGame(), 'Alex'));
    }

    public function testNumericAnswerIsComparedStrictly(): void
    {
        $io = new FakeIo(['1e1']);

        self::assertFalse((new Engine($io))->play(new FixedGame('10'), 'Alex'));
    }

    public function testGreetPrintsNameWithExclamation(): void
    {
        $io = new FakeIo(['Alex']);

        self::assertSame('Alex', (new Engine($io))->greet());
        self::assertContains('Hello, Alex!', $io->output);
    }
}
