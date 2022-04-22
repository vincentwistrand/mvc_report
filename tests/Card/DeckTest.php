<?php

namespace App\Card;
use App\Card\Deck;
use App\Card\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardTDD.
 */
class DeckTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no arguments.
     */
    public function testCreate()
    {
        $deck = new Deck();
        $this->assertInstanceOf("\App\Card\Deck", $deck);
    }

    /**
     * Use createDeck() to create a deck and getDeck() to return the deck.
     * Use no arguments.
     */
    public function testGetDeck()
    {   
        $deck = new Deck();
        $card = new Card("Dam", "Spader", "12");
        $this->assertInstanceOf("\App\Card\Deck", $deck);
    }
}