<?php

namespace App\Card;

class Player
{
    public $player_number = "";
    public $hand = "";

    public function __construct(int $player_number)
    {
        $this->player_number = $player_number;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function setHand(array $cards)
    {
        $this->hand = $cards;
    }
}
