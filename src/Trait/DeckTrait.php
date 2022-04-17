<?php

namespace App\Trait;

use App\Helpfunctions\console_log;
use App\Card\Card;

trait DeckTrait
{
    /**
    * @var array<object>
    */
    private array $cards = array();

    /**
    * @return array<object>
    */
    public function getDeck(): array
    {
        return $this->cards;
    }

    /**
    * @return void
    */
    public function createDeck(): void
    {
        $points = array('2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14');
        $ranks = array('2', '3', '4', '5', '6', '7', '8', '9', '10', 'Knekt', 'Dam', 'Kung', 'Ess');
        $colours  = array('Hjarter', 'Ruter', 'Spader', 'Klover');
        for ($i = 0; $i < count($colours); $i++) {
            for ($x = 0; $x < count($ranks); $x++) {
                $this->cards[] = new \App\Card\Card(
                    $ranks[$x],
                    $colours[$i],
                    $points[$x]
                );
            }
        }
    }

    /**
    * @return void
    */
    public function sortCards(): void
    {
        asort($this->cards);
        $this->cards = array_values($this->cards);
    }

    /**
    * @return void
    */
    public function shuffleCards(): void
    {
        $this->cards = array();
        $this->createDeck();
        //\App\Functions\console_log($this->cards);

        for ($i = 0; $i < 1000; $i++) {
            $indexOne = rand(0, (count($this->cards) - 1));
            $indexTwo = rand(0, (count($this->cards) - 1));
            $savedCard = $this->cards[$indexOne];
            $this->cards[$indexOne] = $this->cards[$indexTwo];
            $this->cards[$indexTwo] = $savedCard;
        }
    }

    /**
    * @return array<object>
    */
    public function drawCards(int $number): array
    {
        $cards = array();

        for ($i = 0; $i < $number; $i++) {
            $card = $this->cards[0];
            $cards[] = $card;
            unset($this->cards[0]);
            $this->cards = array_values($this->cards);
        }

        return $cards;
    }

    /**
    * @return object
    */
    public function drawCard(): object
    {
        $card = $this->cards[0];
        unset($this->cards[0]);
        $this->cards = array_values($this->cards);

        return $card;
    }

    /**
    * @return void
    */
    public function addJokers(): void
    {
        $this->cards[] = new \App\Card\Card("Joker");
        $this->cards[] = new \App\Card\Card("Joker");
    }
}
