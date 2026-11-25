<?php

declare(strict_types=1);

namespace BrainGames;

use BrainGames\Game\GameRegistry;
use BrainGames\Io\InputClosedException;
use BrainGames\Io\IoInterface;

final class Application
{
    public const EXIT_OK = 0;
    public const EXIT_LOST = 1;
    public const EXIT_USAGE = 2;
    public const EXIT_INTERRUPTED = 130;

    private readonly Engine $engine;

    public function __construct(
        private readonly IoInterface  $io,
        private readonly GameRegistry $registry,
    )
    {
        $this->engine = new Engine($io);
    }

    public function runGame(string $id): int
    {
        if (!$this->registry->has($id)) {
            $this->io->line("Unknown game '{$id}'. Available: " . implode(", ", $this->registry->ids()));

            return self::EXIT_USAGE;
        }

        return $this->guard(function () use ($id): int {
            $name = $this->engine->greet();
            $won = $this->engine->play($this->registry->get($id), $name);

            return $won ? self::EXIT_OK : self::EXIT_LOST;
        });
    }

    public function runMenu(): int
    {
        return $this->guard(function (): int {
            $name = $this->engine->greet();
            $menu = new Menu($this->io, $this->registry);

            while (($game = $menu->choose()) !== null) {
                $this->engine->play($game, $name);
            }

            $this->io->line("Bye, {$name}!");

            return self::EXIT_OK;
        });
    }

    /** @param callable(): int $action */
    private function guard(callable $action): int
    {
        try {
            return $action();
        } catch (InputClosedException) {
            $this->io->line();
            $this->io->line('Bye!');

            return self::EXIT_INTERRUPTED;
        }
    }
}
