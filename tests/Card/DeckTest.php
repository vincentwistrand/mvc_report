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
        $this->assertEquals(null, $deck->createDeck());
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

    /**
     * Sort cards using sortCards() and verify that it is sorted.
     * Use no arguments.
     */
    public function testSortCards()
    {   
        $deck = new Deck();
        $deck->createDeck();
        $deck->sortCards();
        $this->assertEquals("2", $deck->getDeck()[0]->getRank());
        $this->assertEquals("3", $deck->getDeck()[1]->getRank());
        $this->assertEquals("2", $deck->getDeck()[13]->getRank());
        $this->assertEquals("3", $deck->getDeck()[14]->getRank());
        $this->assertEquals("2", $deck->getDeck()[26]->getRank());
        $this->assertEquals("3", $deck->getDeck()[27]->getRank());
        $this->assertEquals("2", $deck->getDeck()[39]->getRank());
        $this->assertEquals("3", $deck->getDeck()[40]->getRank());
    }

    /**
     * Sort cards using sortCards() and verify that it is sorted.
     * Use no arguments.
     */
    public function testShuffleCards()
    {   
        $deck = new Deck();
        $deck->createDeck();
        $deck->shuffleCards();
        $rankString = strval($deck->getDeck()[0]->getRank()) . 
                    strval($deck->getDeck()[1]->getRank()) . 
                    strval($deck->getDeck()[2]->getRank()) . 
                    strval($deck->getDeck()[3]->getRank()
                );
        $this->assertNotEquals("2345", $rankString);
    }

    /**
     * Add jokers using addJokers() and verify that deck contains two jokers.
     * Use no arguments.
     */
    public function testAddJokers()
    {   
        $deck = new Deck();
        $deck->createDeck();
        $deck->addJokers();
        $this->assertEquals("Joker", $deck->getDeck()[52]->getRank());
        $this->assertEquals("Joker", $deck->getDeck()[53]->getRank());
    }
}