<?php

declare(strict_types=1);

namespace BrainGames;

use BrainGames\Game\GameInterface;
use BrainGames\Io\IoInterface;

final class Engine
{
    public const DEFAULT_ROUNDS = 3;

    public function __construct(
        private readonly IoInterface $io,
        private readonly int $rounds = self::DEFAULT_ROUNDS,
    ) {
    }

    public function greet(): string
    {
        $this->io->line('Welcome to the Brain Games!');
        $name = trim($this->io->ask('May I have your name?'));
        $name = $name === '' ? 'stranger' : $name;
        $this->io->line("Hello, {$name}!");

        return $name;
    }

    /** @return bool true when every round was answered correctly */
    public function play(GameInterface $game, string $name): bool
    {
        $this->io->line($game->getRules());

        for ($i = 0; $i < $this->rounds; $i++) {
            $round = $game->generateRound();
            $this->io->line("Question: {$round->question}");
            $answer = self::normalize($this->io->ask('Your answer'));

            if ($answer !== $round->correctAnswer) {
                $this->io->line(
                    "'{$answer}' is wrong answer ;(. Correct answer was '{$round->correctAnswer}'."
                );
                $this->io->line("Let's try again, {$name}!");

                return false;
            }
            $this->io->line("Correct!");
        }

        $this->io->line("Congratulations, {$name}!");

        return true;
    }

    private static function normalize(string $answer): string
    {
        return mb_strtolower(trim($answer));
    }
}
