<?php

namespace App\Card;

class Player extends CardHand
{
    public $player_id;
    private $points = 0;

    public function __construct(string $player_name)
    {
        $this->player_id = $player_name;
    }

    public function getPoints(): int
    {   
        return $this->points;
    }

    public function addPoints(int $points): void
    {   
        $this->points +=$points;
    }
}
