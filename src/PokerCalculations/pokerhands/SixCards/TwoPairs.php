<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSixEight(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHSixEightPartTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSixEightPartTwo(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHSixNine($sortPoints);
}
