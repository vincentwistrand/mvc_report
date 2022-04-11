<?php

namespace App\Card;

use App\Trait\DeckTrait;
use App\Interface\Deck2Interface;

class DeckWithTwoJokers implements Deck2Interface
{
    use DeckTrait;
}
