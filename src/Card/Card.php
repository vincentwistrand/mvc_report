<?php

namespace App\Card;

class Card
{   
    public $colour = "";
    public $points = "";
    public $rank = "";

    public function __construct($rank="", $colour="", $points="")
    {
        $this->colour = $colour;
        $this->rank = $rank;
        $this->points = $points;
    }
}
