<?php

namespace App\PokerCalculations;

/**
* Check points for card hand with seven cards and return points
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function SevenCardsRoyalFlush(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Royal flush
    $pointsArray = [];

    foreach ($sortPoints as $card) {
        $pointsArray[] = $card->points;
    }

    $pointsNoDuplicates = array_unique($pointsArray);

    $pointsOrderedKeys = [];

    foreach ($pointsNoDuplicates as $points) {
        $pointsOrderedKeys[] = $points;
    }

    if (count($pointsOrderedKeys) === 5) {
        return SevenCardsRoyalFlushA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    if (count($pointsOrderedKeys) === 6) {
        return SevenCardsRoyalFlushB($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    if (count($pointsOrderedKeys) === 7) {
        return SevenCardsRoyalFlushC($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function SevenCardsRoyalFlushA(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[4] === 14
    ) {
        return checkHandSevenCardsPartTwoA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function SevenCardsRoyalFlushB(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[5] === 14
    ) {
        return checkHandSevenCardsPartTwoA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function SevenCardsRoyalFlushC(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1) &&
        $pointsOrderedKeys[6] === 14
    ) {
        return checkHandSevenCardsPartTwoA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function checkHandSevenCardsPartTwoA(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
): int {
    $pointsNoDuplicates = [];

    $goneThroughtPoints = [];

    foreach ($sortPoints as $card) {
        if (in_array($card->points, $pointsOrderedKeys) && in_array($card->points, $goneThroughtPoints) === false) {
            $pointsNoDuplicates[] = $card;
            $goneThroughtPoints[] = $card->points;
        }
    }

    if (count($pointsNoDuplicates) === 6) {
        array_shift($pointsNoDuplicates);
    }

    if (count($pointsNoDuplicates) === 7) {
        array_shift($pointsNoDuplicates);
        array_shift($pointsNoDuplicates);
    }

    return checkHandSevenCardsPartTwoB($sortPoints, $sortColour, $pointsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int, object> $pointsNoDuplicates
* @param array<object> $cardsInHand
*/
function checkHandSevenCardsPartTwoB(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates,
    array $cardsInHand
): int {
    if (
        $pointsNoDuplicates[0]->colour === $pointsNoDuplicates[1]->colour &&
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour
    ) {
        return SevenCardsRoyalFlushCompare($sortPoints, $sortColour, $pointsNoDuplicates, $cardsInHand);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsNoDuplicates
* @param array<object> $cardsInHand
*/
function SevenCardsRoyalFlushCompare(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates,
    array $cardsInHand
): int {
    dump(in_array($pointsNoDuplicates[3], $cardsInHand));
    dump($cardsInHand[0]);
    if (
        in_array($pointsNoDuplicates[0], $cardsInHand) ||
        in_array($pointsNoDuplicates[1], $cardsInHand) ||
        in_array($pointsNoDuplicates[2], $cardsInHand) ||
        in_array($pointsNoDuplicates[3], $cardsInHand) ||
        in_array($pointsNoDuplicates[4], $cardsInHand)
    ) {
        return 1000;
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour, $cardsInHand);
}
