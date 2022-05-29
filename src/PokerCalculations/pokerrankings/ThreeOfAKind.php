<?php

namespace App\PokerCalculations;

/**
* Returns points of a three of a kind
* @return int
* @param array<object> $sortPoints
*/
function checkThreeOfAKindCards(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points) {
        return 400 + $sortPoints[0]->points + $sortPoints[1]->points  + $sortPoints[2]->points;
    }
    return cTOAKTwo($sortPoints);
}


/**
* @return int
* @param array<object> $sortPoints
*/
function cTOAKTwo(
    array $sortPoints
): int {
    if ($sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points) {
        return 400 + $sortPoints[1]->points + $sortPoints[2]->points  + $sortPoints[3]->points;
    }
    return cTOAKThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTOAKThree(
    array $sortPoints
): int {
    if ($sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points) {
        return 400 + $sortPoints[2]->points + $sortPoints[3]->points  + $sortPoints[4]->points;
    }
    return cTOAKFour($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTOAKFour(
    array $sortPoints
): int {
    if ($sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points) {
        return 400 + $sortPoints[3]->points + $sortPoints[4]->points  + $sortPoints[5]->points;
    }
    return cTOAKFive($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTOAKFive(
    array $sortPoints
): int {
    if ($sortPoints[4]->points === $sortPoints[5]->points && $sortPoints[5]->points === $sortPoints[6]->points) {
        return 400 + $sortPoints[4]->points + $sortPoints[5]->points  + $sortPoints[6]->points;
    }
    return 0;
}
