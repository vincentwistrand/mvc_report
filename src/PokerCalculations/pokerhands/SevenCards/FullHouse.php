<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFour(
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
    return cHSevenFourPartTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFourPartTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFourPartThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFourPartThree(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFourPartFour($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFourPartFour(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFourPartFive($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFourPartFive(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFourPartSix($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSevenFourPartSix(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHSevenFive($sortPoints, $sortColour);
}
