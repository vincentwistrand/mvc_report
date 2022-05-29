<?php

namespace App\PokerCalculations;

/**
* Returns points of a straight flush
* @return int
* @param array<object> $sortPoints
*/
function checkStraightFlushCards(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === ($sortPoints[0]->points + 1) &&
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[0]->colour === $sortPoints[1]->colour &&
        $sortPoints[1]->colour === $sortPoints[2]->colour &&
        $sortPoints[2]->colour === $sortPoints[3]->colour &&
        $sortPoints[3]->colour === $sortPoints[4]->colour
    ) {
        return 900 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cSFTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cSFTwo(
    array $sortPoints
): int {
    if (
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[5]->points === ($sortPoints[4]->points + 1) &&
        $sortPoints[1]->colour === $sortPoints[2]->colour &&
        $sortPoints[2]->colour === $sortPoints[3]->colour &&
        $sortPoints[3]->colour === $sortPoints[4]->colour &&
        $sortPoints[4]->colour === $sortPoints[5]->colour
    ) {
        return 900 + $sortPoints[1]->points + $sortPoints[2]->points +
        $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cSFThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cSFThree(
    array $sortPoints
): int {
    if (
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[5]->points === ($sortPoints[4]->points + 1) &&
        $sortPoints[6]->points === ($sortPoints[5]->points + 1) &&
        $sortPoints[2]->colour === $sortPoints[3]->colour &&
        $sortPoints[3]->colour === $sortPoints[4]->colour &&
        $sortPoints[4]->colour === $sortPoints[5]->colour &&
        $sortPoints[5]->colour === $sortPoints[6]->colour
    ) {
        return 900 + $sortPoints[2]->points + $sortPoints[3]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
