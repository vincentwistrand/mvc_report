<?php

namespace App\PokerCalculations;

/**
* Returns points for card hand with seven cards
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function checkHandSixCards(
    array $sortPoints,
    array $sortColour
): int {
    return sixCardsRoyalFlush($sortPoints, $sortColour);
}
