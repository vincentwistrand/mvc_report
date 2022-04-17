<?php

namespace App\Card;

class Card
{
    public ?string $colour = "";
    public ?string $points = "";
    public ?string $rank = "";

    public function __construct(?string $rank = "", ?string $colour = "", ?string $points = "")
    {
        $this->colour = $colour;
        $this->rank = $rank;
        $this->points = $points;
    }
}
