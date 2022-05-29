<?php

namespace App\PokerCalculations;

/**
* Returns points of a pair
* @return int
* @param array<object> $sortPoints
*/
function checkPairCards(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points) {
        return 200 + $sortPoints[0]->points + $sortPoints[1]->points;
    } elseif ($sortPoints[1]->points === $sortPoints[2]->points) {
        return 200 + $sortPoints[1]->points + $sortPoints[2]->points;
    } elseif ($sortPoints[2]->points === $sortPoints[3]->points) {
        return 200 + $sortPoints[2]->points + $sortPoints[3]->points;
    } elseif ($sortPoints[3]->points === $sortPoints[4]->points) {
        return 200 + $sortPoints[3]->points + $sortPoints[4]->points;
    } elseif ($sortPoints[4]->points === $sortPoints[5]->points) {
        return 200 + $sortPoints[4]->points + $sortPoints[5]->points;
    } elseif ($sortPoints[5]->points === $sortPoints[6]->points) {
        return 200 + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
