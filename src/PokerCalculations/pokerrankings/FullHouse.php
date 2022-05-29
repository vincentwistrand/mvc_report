<?php

namespace App\PokerCalculations;

/**
* Returns points of a full house
* @return int
* @param array<object> $sortPoints
*/
function checkFullHouseCards(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points  + $sortPoints[2]->points +
        $sortPoints[3]->points  + $sortPoints[4]->points;
    }
    return cFHTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHTwo(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cFHThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHThree(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cFHFour($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHFour(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        return 700 + $sortPoints[1]->points + $sortPoints[2]->points +
        $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cFHFive($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHFive(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 700 + $sortPoints[1]->points + $sortPoints[2]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cFHSix($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHSix(
    array $sortPoints
): int {
    if (
        $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 700 + $sortPoints[2]->points + $sortPoints[3]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cFHSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHSeven(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cFHEight($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHEight(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[2]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cFHNine($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHNine(
    array $sortPoints
): int {
    if (
        $sortPoints[0]->points === $sortPoints[1]->points &&
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 700 + $sortPoints[0]->points + $sortPoints[1]->points +
        $sortPoints[2]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cFHTen($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHTen(
    array $sortPoints
): int {
    if (
        $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        return 700 + $sortPoints[1]->points + $sortPoints[2]->points +
        $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cFHEleven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cFHEleven(
    array $sortPoints
): int {
    if (
        $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        return 700 + $sortPoints[2]->points + $sortPoints[3]->points +
        $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
