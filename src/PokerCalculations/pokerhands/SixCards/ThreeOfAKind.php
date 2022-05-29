<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSixSeven(
    array $sortPoints
): int {
    // Three of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSixEight($sortPoints);
}
