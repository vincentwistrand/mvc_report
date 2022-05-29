<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHSixTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Straight flush
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
        return sixCardsStraightFlushA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 6) {
        return sixCardsStraightFlushB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function sixCardsStraightFlushA(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        return cHSixTwoPartA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function sixCardsStraightFlushB(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
    ) {
        return cHSixTwoPartBOne($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sixCardsStraightFlushC($sortPoints, $sortColour, $pointsOrderedKeys);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function sixCardsStraightFlushC(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        return cHSixTwoPartBTwo($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return cHSixThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function cHSixTwoPartA(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys
): int {
    // Straight flush
    $pointsNoDuplicates = [];

    $goneThroughtPoints = [];

    foreach ($sortPoints as $card) {
        if (in_array($card->points, $pointsOrderedKeys) && in_array($card->points, $goneThroughtPoints) === false) {
            $pointsNoDuplicates[] = $card;
            $goneThroughtPoints[] = $card->points;
        }
    }

    if (
        $pointsNoDuplicates[0]->colour === $pointsNoDuplicates[1]->colour &&
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour
    ) {
        $totalPoints = checkStraightFlushCards($pointsNoDuplicates);
        return $totalPoints;
    }

    return cHSixThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function cHSixTwoPartBOne(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys
): int {
    // Straight flush
    $pointsNoDuplicates = [];

    $goneThroughtPoints = [];

    foreach ($sortPoints as $card) {
        if (in_array($card->points, $pointsOrderedKeys) && in_array($card->points, $goneThroughtPoints) === false) {
            $pointsNoDuplicates[] = $card;
            $goneThroughtPoints[] = $card->points;
        }
    }

    if (
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour &&
        $pointsNoDuplicates[4]->colour === $pointsNoDuplicates[5]->colour
    ) {
        $totalPoints = cSFTwo($pointsNoDuplicates);
        return $totalPoints;
    }

    return cHSixThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsOrderedKeys
*/
function cHSixTwoPartBTwo(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys
): int {
    // Straight flush
    $pointsNoDuplicates = [];

    $goneThroughtPoints = [];

    foreach ($sortPoints as $card) {
        if (in_array($card->points, $pointsOrderedKeys) && in_array($card->points, $goneThroughtPoints) === false) {
            $pointsNoDuplicates[] = $card;
            $goneThroughtPoints[] = $card->points;
        }
    }

    if (
        $pointsNoDuplicates[0]->colour === $pointsNoDuplicates[1]->colour &&
        $pointsNoDuplicates[1]->colour === $pointsNoDuplicates[2]->colour &&
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour
    ) {
        $totalPoints = checkStraightFlushCards($pointsNoDuplicates);
        return $totalPoints;
    }

    return cHSixThree($sortPoints, $sortColour);
}
