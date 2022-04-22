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
     * Use no arguments.
     */
    public function testCreate()
    {
        $game = new Game();
        $this->assertInstanceOf("\App\Card\Game", $game);
    }
}