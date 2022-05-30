<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFourOfAKind(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Four of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkFourOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return cHSevenThreePartTwo($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function cHSevenThreePartTwo(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Four of a kind
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkFourOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return cHSevenThreePartThree($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function cHSevenThreePartThree(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Four of a kind
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkFourOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return cHSevenThreePartFour($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function cHSevenThreePartFour(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Four of a kind
    if (
        $sortPoints[3]->points === $sortPoints[4]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFourOfAKindCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouse($sortPoints, $sortColour, $cardsInHand);
}
