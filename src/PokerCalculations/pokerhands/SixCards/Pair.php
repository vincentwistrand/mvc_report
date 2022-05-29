<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSixNine(
    array $sortPoints
): int {
    // Pair
    if (
        $sortPoints[0]->points === $sortPoints[1]->points || $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points || $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkPairCards($sortPoints);
        return $totalPoints;
    }

    $cardPoints = 0;
    foreach ($sortPoints as $card) {
        $cardPoints += $card->points;
    }

    return $cardPoints;
}
