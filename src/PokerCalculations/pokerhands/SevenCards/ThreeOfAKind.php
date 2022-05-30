<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsThreeOfAKind(
    array $sortPoints,
    array $cardsInHand
): int {
    // Three of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand)
        ) {
            $totalPoints = checkThreeOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsThreeOfAKindTwo($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsThreeOfAKindTwo(
    array $sortPoints,
    array $cardsInHand
): int {
    // Three of a kind
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand)
        ) {
            $totalPoints = checkThreeOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsThreeOfAKindThree($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsThreeOfAKindThree(
    array $sortPoints,
    array $cardsInHand
): int {
    // Three of a kind
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkThreeOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsThreeOfAKindFour($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsThreeOfAKindFour(
    array $sortPoints,
    array $cardsInHand
): int {
    // Three of a kind
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkThreeOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsThreeOfAKindFive($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsThreeOfAKindFive(
    array $sortPoints,
    array $cardsInHand
): int {
    // Three of a kind
    if (
        $sortPoints[4]->points === $sortPoints[5]->points && $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkThreeOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsTwoPairs($sortPoints, $cardsInHand);
}
