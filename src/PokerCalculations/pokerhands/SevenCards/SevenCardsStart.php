<?php

namespace App\PokerCalculations;

/**
* Returns points for card hand with seven cards
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function checkHandSevenCards(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    return sevenCardsRoyalFlush($sortPoints, $sortColour, $cardsInHand);
}
