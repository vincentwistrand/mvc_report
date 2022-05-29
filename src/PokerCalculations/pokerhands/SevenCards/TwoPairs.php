<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenEight(
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
    return cHSevenEightPartTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenEightPartTwo(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenEightPartThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenEightPartThree(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenNine($sortPoints);
}
