<?php

namespace App\PokerCalculations;

/**
* Check card hand with four cards and return points
* @return int
* @param array<object> $sortPoints
*/
function checkHandFourCards(
    array $sortPoints
): int {
    // Four of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHFourTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFourTwo(
    array $sortPoints
): int {
    // Three of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHFourThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFourThree(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHFourFour($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFourFour(
    array $sortPoints
): int {
    // Pair
    if (
        $sortPoints[0]->points === $sortPoints[1]->points || $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        $totalPoints = checkPairCards($sortPoints);
        return $totalPoints;
    }
    return 0;
}
