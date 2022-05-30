<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairs(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsTwo($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsTwo(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsThree($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsThree(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsFour($sortPoints, $cardsInHand);
}


/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsFour(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsFive($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsFive(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsSix($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsSix(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsSeven($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsSeven(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsEight($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsEight(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsNine($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsNine(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairsTen($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsTwoPairsTen(
    array $sortPoints,
    array $cardsInHand
): int {
    // Two pairs
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkTwoPairsCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsPair($sortPoints, $cardsInHand);
}
