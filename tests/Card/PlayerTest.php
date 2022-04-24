<?php

namespace App\Card;

use App\Card\Player;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class CardTDD.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object is of expected instance.
     * Use no arguments.
     */
    public function testCreate()
    {
        $player = new Player("Player");
        $this->assertInstanceOf("\App\Card\Player", $player);
    }
}
