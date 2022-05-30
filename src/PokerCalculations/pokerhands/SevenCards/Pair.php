<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPair(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[0]->points === $sortPoints[1]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairTwo($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPairTwo(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[1]->points === $sortPoints[2]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairThree($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPairThree(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairFour($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPairFour(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairFive($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPairFive(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairSix($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsPairSix(
    array $sortPoints,
    array $cardsInHand
): int {
    // Pair
    if (
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkPairCards($sortPoints);
            return $totalPoints;
        }
    }

    return sevenCardsPairSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function sevenCardsPairSeven(
    array $sortPoints
): int {
    // If nothing
    $cardPoints = 0;
    foreach ($sortPoints as $card) {
        $cardPoints += $card->points;
    }

    return $cardPoints;
}
