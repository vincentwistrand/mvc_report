<?php

namespace App\Card;

class Card
{
    private string $colour = "";
    private string $points = "";
    private string $rank = "";

    public function __construct(string $rank = "", string $colour = "", string $points = "")
    {
        $this->colour = $colour;
        $this->rank = $rank;
        $this->points = $points;
    }

    /**
    * @return string
    */
    public function getColour(): string
    {
        return $this->colour;
    }

    /**
    * @return string
    */
    public function getPoints(): string
    {
        return $this->points;
    }

    /**
    * @return string
    */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
    * @return array
    */
    public function getProperties(): array
    {
        $properties = array(
            "Colour"=>$this->colour,
            "Rank"=>$this->rank,
            "Points"=>$this->points
        );
        return $properties;
    }
}
