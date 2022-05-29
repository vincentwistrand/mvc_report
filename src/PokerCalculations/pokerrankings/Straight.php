<?php

namespace App\PokerCalculations;

/**
* Returns points of a straight
* @return int
* @param array<object> $sortPoints
*/
function checkStraightCards(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === ($sortPoints[0]->points + 1) &&
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1)
    ) {
        return 500 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cSTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cSTwo(
    array $sortPoints
): int {
    if (
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[5]->points === ($sortPoints[4]->points + 1)
    ) {
        return 500 + $sortPoints[1]->points + $sortPoints[2]->points +
        $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cSThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cSThree(
    array $sortPoints
): int {
    if (
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[5]->points === ($sortPoints[4]->points + 1) &&
        $sortPoints[6]->points === ($sortPoints[5]->points + 1)
    ) {
        return 500 + $sortPoints[2]->points + $sortPoints[3]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
