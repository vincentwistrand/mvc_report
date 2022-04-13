<?php

namespace App\Card;

use App\Trait\DeckTrait;
use App\Interface\DeckInterface;
use App\Functions\console_log;
use App\Card\Card;

class Deck implements DeckInterface
{
    use DeckTrait;
}
