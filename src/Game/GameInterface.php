<?php

declare(strict_types=1);

namespace BrainGames\Game;

interface GameInterface
{
    /** Short id used in the menu and as the binary suffix: "even", "calc", etc */
    public function getId(): string;
    public function getTitle(): string;
    public function getRules(): string;
    public function generateRound(): Round;
}
