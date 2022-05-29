<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixFour(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSixFourPartTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixFourPartTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSixFourPartThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixFourPartThree(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSixFive($sortPoints, $sortColour);
}
