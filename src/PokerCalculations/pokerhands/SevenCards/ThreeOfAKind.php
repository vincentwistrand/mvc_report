<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenSeven(
    array $sortPoints
): int {
    // Three of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenSevenPartTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenSevenPartTwo(
    array $sortPoints
): int {
    // Three of a kind
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points ||
        $sortPoints[4]->points === $sortPoints[5]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenEight($sortPoints);
}
