<?php

namespace App\Card;

class CardHand
{
    public $cards = array();

    public function getCards(): array
    {
        return $this->cards;
    }

    public function getCardCount(): array
    {
        return count($this->cards);
    }

    public function addCard(object $card): void
    {   
        $this->cards[] = $card;
    }
}