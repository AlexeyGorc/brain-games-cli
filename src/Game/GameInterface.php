<?php

declare(strict_types=1);

namespace BrainGames\Game;

interface GameInterface
{
    public function getId(): string;
    public function getTitle(): string;
    public function getRules(): string;
    public function generateRound(): Round;
}
