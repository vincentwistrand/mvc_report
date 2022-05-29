<?php

namespace App\PokerCalculations;

/**
* Returns points of a two pair
* @return int
* @param array<object> $sortPoints
*/
function checkTwoPairsCards(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points) {
        return 300 + $sortPoints[0]->points + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[3]->points;
    }
    return cTPCTwo($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCTwo(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points) {
        return 300 + $sortPoints[0]->points + $sortPoints[1]->points + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cTPCThree($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCThree(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[4]->points === $sortPoints[5]->points) {
        return 300 + $sortPoints[0]->points + $sortPoints[1]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cTPCFour($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCFour(
    array $sortPoints
): int {
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[5]->points === $sortPoints[6]->points) {
        return 300 + $sortPoints[0]->points + $sortPoints[1]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cTPCFive($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCFive(
    array $sortPoints
): int {
    if ($sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points) {
        return 300 + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points;
    }
    return cTPCSix($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCSix(
    array $sortPoints
): int {
    if ($sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points) {
        return 300 + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cTPCSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCSeven(
    array $sortPoints
): int {
    if ($sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[5]->points === $sortPoints[6]->points) {
        return 300 + $sortPoints[1]->points + $sortPoints[2]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cTPCEight($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCEight(
    array $sortPoints
): int {
    if ($sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points) {
        return 300 + $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points;
    }
    return cTPCNine($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCNine(
    array $sortPoints
): int {
    if ($sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[5]->points === $sortPoints[6]->points) {
        return 300 + $sortPoints[2]->points + $sortPoints[3]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return cTPCTen($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cTPCTen(
    array $sortPoints
): int {
    if ($sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[5]->points === $sortPoints[6]->points) {
        return 300 + $sortPoints[3]->points + $sortPoints[4]->points + $sortPoints[5]->points + $sortPoints[6]->points;
    }
    return 0;
}
