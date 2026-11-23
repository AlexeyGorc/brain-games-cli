<?php

declare(strict_types=1);

namespace BrainGames\Game;

use InvalidArgumentException;

final class GameRegistry
{
    /** @var array<string, GameInterface> */
    private array $games = [];

    public function __construct(GameInterface ...$games)
    {
        foreach ($games as $game) {
            $this->games[$game->getId()] = $game;
        }
    }

    public static function default(): self
    {
        return new self(
            new EvenGame(),
            new CalcGame(),
            new GcdGame(),
            new ProgressionGame(),
            new PrimeGame(),
        );
    }

    /** @return list<GameInterface> */
    public function all(): array
    {
        return array_values($this->games);
    }

    public function has(string $id): bool
    {
        return isset($this->games[$id]);
    }

    /** @return list<string> */
    public function ids(): array
    {
        return array_keys($this->games);
    }

    public function get(string $id): GameInterface
    {
        return $this->games[$id] ?? throw new InvalidArgumentException("Unknown game: {$id}");
    }
}
