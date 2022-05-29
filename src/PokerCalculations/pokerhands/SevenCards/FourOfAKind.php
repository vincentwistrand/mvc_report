<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function sevenCardsFourOfAKind(
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
    return cHSevenThreePartTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenThreePartTwo(
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
    return cHSevenThreePartThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenThreePartThree(
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
    return cHSevenThreePartFour($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenThreePartFour(
    array $sortPoints,
    array $sortColour
): int {
    // Four of a kind
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFour($sortPoints, $sortColour);
}
