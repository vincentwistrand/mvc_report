<?php

namespace App\PokerCalculations;

/**
* Check points for card hand with seven cards and return points
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function SevenCardsRoyalFlush(
    array $sortPoints,
    array $sortColour
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
        return SevenCardsRoyalFlushA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 6) {
        return SevenCardsRoyalFlushB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 7) {
        return SevenCardsRoyalFlushC($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function SevenCardsRoyalFlushA(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[4] === 14
    ) {
        return checkHandSevenCardsPartTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function SevenCardsRoyalFlushB(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[5] === 14
    ) {
        return checkHandSevenCardsPartTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function SevenCardsRoyalFlushC(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1) &&
        $pointsOrderedKeys[6] === 14
    ) {
        return checkHandSevenCardsPartTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function checkHandSevenCardsPartTwo(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys
): int {
    // Royal flush
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

    return checkHandSevenCardsPartTwoA($sortPoints, $sortColour, $pointsNoDuplicates);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int, object> $pointsNoDuplicates
*/
function checkHandSevenCardsPartTwoA(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates
): int {
    if (
        $pointsNoDuplicates[0]->colour === $pointsNoDuplicates[1]->colour &&
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour
    ) {
        return 1000;
    }

    return sevenCardsStraightFlush($sortPoints, $sortColour);
}
