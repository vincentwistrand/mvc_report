<?php

namespace App\Dice;

use App\Dice\Dice;

class DiceHand
{
    /**
    * @var array<object>
    */
    private array $hand = [];

    /**
    * @return void
    */
    public function add(Dice $die): void
    {
        $this->hand[] = $die;
    }

    /**
    * @return void
    */
    public function roll(): void
    {
        foreach ($this->hand as $die) {
            $die->roll();
        }
    }

    /**
    * @return int
    */
    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    /**
    * @return string
    */
    public function getAsString(): string
    {
        $str = "";
        foreach ($this->hand as $die) {
            $str .= $die->getAsString();
        }
        return $str;
    }
}
