<?php

namespace App\Card;

class Player extends CardHand
{
    private string $player_id;

    public function __construct(string $player_name)
    {
        $this->player_id = $player_name;
    }

    /**
    * @return string
    */
    public function getPlayerId(): string
    {
        return $this->player_id;
    }
}
