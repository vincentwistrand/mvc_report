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
        $deck->createDeck();
        $this->assertEquals(52, count($deck->getDeck()));
    }

    /**
     * Draw cards from deck and verify that it works.
     * Use number as arguments.
     */
    public function testDrawCards()
    {   
        $deck = new Deck();
        $deck->createDeck();
        $deck->drawCard();
        $this->assertEquals(51, count($deck->getDeck()));
        $cards = $deck->drawCards(6);
        $this->assertEquals(45, count($deck->getDeck()));
    }
}