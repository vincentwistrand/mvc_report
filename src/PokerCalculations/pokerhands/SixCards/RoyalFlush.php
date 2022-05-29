<?php

namespace App\PokerCalculations;

/**
* Check card hand with six cards and return points
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function sixCardsRoyalFlush(
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
        return SixCardsRoyalFlushA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 6) {
        return SixCardsRoyalFlushB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function SixCardsRoyalFlushA(
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
        return checkHandSixCardsPartTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function SixCardsRoyalFlushB(
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
        return checkHandSixCardsPartTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function checkHandSixCardsPartTwo(
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

    dump($pointsNoDuplicates);

    if (count($pointsNoDuplicates) === 6) {
        array_shift($pointsNoDuplicates);
    }

    dump($pointsNoDuplicates);

    if (
        $pointsNoDuplicates[0]->colour === $pointsNoDuplicates[1]->colour &&
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour
    ) {
        return 1000;
    }

    return cHSixTwo($sortPoints, $sortColour);
}
