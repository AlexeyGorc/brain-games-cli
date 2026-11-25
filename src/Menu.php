<?php

declare(strict_types=1);

namespace BrainGames;

use BrainGames\Game\GameInterface;
use BrainGames\Game\GameRegistry;
use BrainGames\Io\IoInterface;

final class Menu
{
    public function __construct(
        private readonly IoInterface $io,
        private readonly GameRegistry $registry,
    ) {
    }

    public function choose(): ?GameInterface
    {
        $games = $this->registry->all();

        while (true) {
            $this->io->line();
            $this->io->line('Choose a game:');

            foreach ($games as $index => $game) {
                $this->io->line(sprintf('  %d. %s', $index + 1, $game->getTitle()));
            }
            $this->io->line('  0. Exit');

            $choice = trim($this->io->ask('Your choice'));

            if ($choice === '0') {
                return null;
            }

            if (ctype_digit($choice) && isset($games[(int) $choice - 1])) {
                return $games[(int) $choice - 1];
            }

            $this->io->line("'{$choice}' is not a valid option.");
        }
    }
}
