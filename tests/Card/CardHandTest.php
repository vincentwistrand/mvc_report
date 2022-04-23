<?php

namespace App\Card;
use App\Card\Card;
use App\Card\CardHandTTD;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardHandTDD.
 */
class CardHandTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no arguments.
     */
    public function testCreate()
    {
        $cardHand = new CardHand();
        $this->assertInstanceOf("\App\Card\CardHand", $cardHand);
    }

    /**
     * Verify that method addCard adds a Card object to CardHand and getCards returns the card.
     * addCard() passes a Card object as argument.
     */
    public function testAddAndGetCard()
    {   
        $card = new Card("Kung", "Ruter", "13");
        $cardHand = new CardHand();
        $cardHand->addCard($card);
        $this->assertSame($card, $cardHand->getCards()[0]);
    }

    /**
     * Verify that method getCardCount returns amount of cards in deck.
     * Use no arguments.
     */
    public function testGetCardCount()
    {   
        $cardHand = new CardHand();
        $card = new Card();
        $cardCount = 3;
        for ($i=0; $i < $cardCount; $i++) { 
            $cardHand->addCard($card);
        }
        $this->assertSame($cardCount, $cardHand->getCardCount());
    }
}