<?php

namespace App\Card;

class Player extends CardHand
{
    public string $player_id;

    public function __construct(string $player_name)
    {
        $this->player_id = $player_name;
    }
}
