<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFlush(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Flush
    if (
        $sortColour[0]->colour === $sortColour[4]->colour
    ) {
        if (
            in_array($sortColour[0], $cardsInHand) ||
            in_array($sortColour[1], $cardsInHand) ||
            in_array($sortColour[2], $cardsInHand) ||
            in_array($sortColour[3], $cardsInHand) ||
            in_array($sortColour[4], $cardsInHand)
        ) {
            $totalPoints = checkFlushCards($sortColour, $sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFlushTwo($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFlushTwo(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Flush
    if (
        $sortColour[1]->colour === $sortColour[5]->colour
    ) {
        if (
            in_array($sortColour[1], $cardsInHand) ||
            in_array($sortColour[2], $cardsInHand) ||
            in_array($sortColour[3], $cardsInHand) ||
            in_array($sortColour[4], $cardsInHand) ||
            in_array($sortColour[5], $cardsInHand)
        ) {
            $totalPoints = checkFlushCards($sortColour, $sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFlushThree($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFlushThree(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Flush
    if (
        $sortColour[2]->colour === $sortColour[6]->colour
    ) {
        if (
            in_array($sortColour[2], $cardsInHand) ||
            in_array($sortColour[3], $cardsInHand) ||
            in_array($sortColour[4], $cardsInHand) ||
            in_array($sortColour[5], $cardsInHand) ||
            in_array($sortColour[6], $cardsInHand)
        ) {
            $totalPoints = checkFlushCards($sortColour, $sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsStraight($sortPoints, $cardsInHand);
}
