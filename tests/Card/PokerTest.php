<?php

namespace App\Card;

use App\Card\Poker;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardTDD.
 */
class PokerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     */
    public function testCreate()
    {
        $poker_game = new Poker();
        $this->assertInstanceOf("\App\Card\Poker", $poker_game);
    }

    /**
     * Method dealCardsToPlayers() should draw two cards to player and getPlayerCards() and 
     * getBankCards() should return them.
     */
    public function testDealCardsToPlayers()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Player');
        $poker_game->dealCardsToPlayers();
        $this->assertIsObject($poker_game->getPlayerCards()[0]);
        $this->assertIsObject($poker_game->getPlayerCards()[1]);
        $this->assertIsObject($poker_game->getBankCards()[0]);
        $this->assertIsObject($poker_game->getBankCards()[1]);
        $this->assertEquals(2, count($poker_game->getPlayerCards()));
        $this->assertEquals(2, count($poker_game->getBankCards()));
    }

    /**
     * Method dealOneCardToTable() should draw one card to the table and getTableCards() should 
     * return them.
     */
    public function testDealOneCardToTable()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Player');
        $poker_game->dealOneCardToTable();
        $this->assertIsObject($poker_game->getTableCards()[0]);
    }

    /**
     * Method dealThreeCardToTable() should draw one card to the table.
     */
    public function testDealThreeCardsToTable()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Player');
        $poker_game->dealThreeCardsToTable();
        $this->assertEquals(3, count($poker_game->getTableCards()));
    }

    /**
     * Method addToPot() should add an amount of money and getPot should return it.
     */
    public function testAddAndGetPot()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Player');
        $poker_game->addToPot(10);
        $this->assertEquals(10, $poker_game->getPot(10));
    }

    /**
     * Method setGameOver() should set $gameOver to true and getGameOver() should return it.
     */
    public function testGameOver()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Player');
        $this->assertEquals(false, $poker_game->hasGameEnded());
        $poker_game->setGameOver();
        $this->assertEquals(true, $poker_game->hasGameEnded());
    }

    /**
     * Method getPlayerUsername() should return player username.
     */
    public function testGetPlayerUsername()
    {
        $poker_game = new Poker();
        $poker_game->newRound('Gustav');
        $this->assertEquals('Gustav', $poker_game->getPlayerUsername());
    }
}
