<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function sevenCardsStraightFlush(
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
        return sevenCardsStraightFlushA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 6) {
        return sevenCardsStraightFlushB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    if (count($pointsOrderedKeys) === 7) {
        return sevenCardsStraightFlushD($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushA(
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
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushB(
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
        return sevenCardsStraightFlushColourB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlushC($sortPoints, $sortColour, $pointsOrderedKeys);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushC(
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
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushD(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys
): int {
    if (
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1)
    ) {
        return sevenCardsStraightFlushColourC($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlushE($sortPoints, $sortColour, $pointsOrderedKeys);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushE(
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
        return sevenCardsStraightFlushColourB($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsStraightFlushF($sortPoints, $sortColour, $pointsOrderedKeys);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushF(
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
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushColourA(
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

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushColourB(
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

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
*/
function sevenCardsStraightFlushColourC(
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
        $pointsNoDuplicates[2]->colour === $pointsNoDuplicates[3]->colour &&
        $pointsNoDuplicates[3]->colour === $pointsNoDuplicates[4]->colour &&
        $pointsNoDuplicates[4]->colour === $pointsNoDuplicates[5]->colour &&
        $pointsNoDuplicates[5]->colour === $pointsNoDuplicates[6]->colour
    ) {
        $totalPoints = cSFThree($pointsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour);
}
