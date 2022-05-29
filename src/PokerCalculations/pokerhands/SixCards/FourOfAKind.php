<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixThree(
    array $sortPoints,
    array $sortColour
): int {
    // Four of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSixThreePartTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixThreePartTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Four of a kind
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSixThreePartThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixThreePartThree(
    array $sortPoints,
    array $sortColour
): int {
    // Four of a kind
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSixFour($sortPoints, $sortColour);
}
