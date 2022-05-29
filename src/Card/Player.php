<?php

namespace App\Card;

class Player extends CardHand
{
    private string $playerId;

    public function __construct(string $playerName)
    {
        $this->playerId = $playerName;
    }

    /**
    * @return string
    */
    public function getPlayerId(): string
    {
        return $this->playerId;
    }
}
