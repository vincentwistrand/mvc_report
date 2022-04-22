<?php

namespace App\Card;
use App\Card\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardTDD.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no arguments.
     */
    public function testCreate()
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    /**
     * See if method getColour return card colour.
     * Use all arguments.
     */
    public function testGetColour()
    {
        $card = new Card("Kung", "Spader", "13");
        $this->assertEquals("Spader", $card->getColour());
    }

    /**
     * See if method getRank return card rank.
     * Use all arguments.
     */
    public function testGetRank()
    {
        $card = new Card("Kung", "Spader", "13");
        $this->assertEquals("Kung", $card->getRank());
    }

    /**
     * See if method getPoints return card points.
     * Use all arguments.
     */
    public function testGetPoints()
    {
        $card = new Card("Kung", "Spader", "13");
        $this->assertEquals("13", $card->getPoints());
    }
}