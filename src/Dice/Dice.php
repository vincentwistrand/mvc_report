<?php

namespace App\Dice;

class Dice
{
    /**
    * @var int
    */
    protected int $value;

    /**
    * @return void
    */
    public function __construct()
    {
        $this->value = random_int(1, 6);
    }

    /**
    * @return int
    */
    public function roll(): int
    {
        $this->value = random_int(1, 6);
        return $this->value;
    }

    /**
    * @return string
    */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
