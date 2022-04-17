<?php

namespace App\Card;

class CardHand
{   
    /**
    * @var array<object>
    */
    private array $cards = array();

    /**
    * @return array<object>
    */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
    * @return int
    */
    public function getCardCount(): int
    {
        return count($this->cards);
    }

    /**
    * @return void
    */
    public function addCard(object $card): void
    {
        $this->cards[] = $card;
    }
}
