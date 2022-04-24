<?php

namespace App\Card;

use App\Card\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardTDD.
 */
class GameTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     */
    public function testCreate()
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Card\Game", $game);
    }

    /**
     * Use drawCardToPlayer() to draw a card to the player and see if getPlayerCards() returns it.
     */
    public function testDrawAndGetPlayerCard()
    {
        $game = new Game();
        $game->newRound();
        $card = $game->drawCardToPlayer();
        $this->assertEquals($card, $game->getPlayerCards()[0]);
    }

    /**
     * Use drawCardToPlayer() to draw a card to the player and see if getPlayerCardCount() returns correct card count.
     */
    public function testDrawAndGetPlayerCardCount()
    {
        $game = new Game();
        $game->newRound();
        $this->assertEquals(0, $game->getPlayerCardCount());
        $game->drawCardToPlayer();
        $this->assertEquals(1, $game->getPlayerCardCount());
    }

    /**
     * Use drawCardToBank() to draw three cards to the bank and see if getBankCards() returns the same cards.
     */
    public function testBankCards()
    {
        srand(2);
        $game = new Game();
        $game->newRound();
        $this->assertEquals(array(), $game->getBankCards());
        $cards = $game->drawCardsToBank();
        $this->assertEquals($cards, $game->getBankCards());
    }

    /**
     * Use drawCardToPlayer() to draw a card to the player and see if getPlayerPoints() returns correct points.
     */
    public function testGetPlayerPoints()
    {
        $game = new Game();
        $game->newRound();
        $this->assertEquals(0, $game->getPlayerPoints());
        $card = $game->drawCardToPlayer();
        $this->assertEquals($card->getPoints(), $game->getPlayerPoints());
    }

    /**
     * Use checkPlayerPoints() to see if it return true if player points > 21, else false.
     */
    public function testCheckPlayerPoints()
    {
        srand(14);
        $game = new Game();
        $game->newRound();
        $this->assertEquals(false, $game->checkPlayerPoints());
        $game->drawCardToPlayer();
        $game->drawCardToPlayer();
        $this->assertEquals(true, $game->checkPlayerPoints());
    }

    /**
     * Use checkPlayerPoints() to see if it return true if player points > 21, else false.
     */
    public function testCheckBankPoints()
    {
        srand(14);
        $game = new Game();
        $game->newRound();
        $this->assertEquals(false, $game->checkBankPoints());
        $game->drawCardsToBank();
        $this->assertEquals(true, $game->checkBankPoints());
    }
}
