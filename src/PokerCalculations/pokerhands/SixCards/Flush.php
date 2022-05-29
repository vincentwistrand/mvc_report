<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixFive(
    array $sortPoints,
    array $sortColour
): int {
    // Flush
    if (
        $sortColour[0]->colour === $sortColour[4]->colour ||
        $sortColour[1]->colour === $sortColour[5]->colour
    ) {
        $totalPoints = checkFlushCards($sortColour, $sortPoints);
        return $totalPoints;
    }
    return cHSixSix($sortPoints);
}
