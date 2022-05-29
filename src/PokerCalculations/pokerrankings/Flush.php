<?php

namespace App\PokerCalculations;

/**
* Returns points of a flush
* @return int
* @param array<object> $sortColour
* @param array<object> $sortPoints
*/
function checkFlushCards(
    array $sortColour,
    array $sortPoints
): int {
    if ($sortColour[0]->colour === $sortColour[4]->colour) {
        return 600 + $sortPoints[0]->points + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[3]->points +
        $sortPoints[4]->points;
    } elseif ($sortColour[1]->colour === $sortColour[5]->colour) {
        return 600 + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points +
        $sortPoints[5]->points;
    } elseif ($sortColour[2]->colour === $sortColour[6]->colour) {
        return 600 + $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points +
        $sortPoints[6]->points;
    }
    return 0;
}
