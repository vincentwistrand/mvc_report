<?php

namespace App\PokerCalculations;

/**
* Returns points of a four of a kind
* @return int
* @param array<object> $sortPoints
*/
function checkFourOfAKindCards(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        return 800 + $sortPoints[0]->points + $sortPoints[1]->points  + $sortPoints[2]->points + $sortPoints[3]->points;
    }
    return cFOAKTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFOAKTwo(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        return 800 + $sortPoints[1]->points + $sortPoints[2]->points  + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cFOAKThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFOAKThree(
    array $sortPoints
): int {
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        return 800 + $sortPoints[2]->points + $sortPoints[3]->points  + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cFOAKFour($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFOAKFour(
    array $sortPoints
): int {
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 800 + $sortPoints[3]->points + $sortPoints[4]->points  + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
