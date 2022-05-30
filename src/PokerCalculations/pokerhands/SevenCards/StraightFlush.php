<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlush(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
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
        return sevenCardsStraightFlushA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    if (count($pointsOrderedKeys) === 6) {
        return sevenCardsStraightFlushB($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    if (count($pointsOrderedKeys) === 7) {
        return sevenCardsStraightFlushD($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushA(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushB(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
    ) {
        return sevenCardsStraightFlushColourB($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlushC($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushC(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushD(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
        $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1)
    ) {
        return sevenCardsStraightFlushColourC($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlushE($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushE(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
    ) {
        return sevenCardsStraightFlushColourB($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsStraightFlushF($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushF(
    array $sortPoints,
    array $sortColour,
    $pointsOrderedKeys,
    array $cardsInHand
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        return sevenCardsStraightFlushColourA($sortPoints, $sortColour, $pointsOrderedKeys, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourA(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
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
        return sevenCardsStraightFlushColourACompare($sortPoints, $sortColour, $pointsNoDuplicates, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourB(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
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
        return sevenCardsStraightFlushColourBCompare($sortPoints, $sortColour, $pointsNoDuplicates, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourC(
    array $sortPoints,
    array $sortColour,
    array $pointsOrderedKeys,
    array $cardsInHand
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
        return sevenCardsStraightFlushColourCCompare($sortPoints, $sortColour, $pointsNoDuplicates, $cardsInHand);
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsNoDuplicates
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourACompare(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($pointsNoDuplicates[0], $cardsInHand) ||
        in_array($pointsNoDuplicates[1], $cardsInHand) ||
        in_array($pointsNoDuplicates[2], $cardsInHand) ||
        in_array($pointsNoDuplicates[3], $cardsInHand) ||
        in_array($pointsNoDuplicates[4], $cardsInHand)
    ) {
        $totalPoints = checkStraightFlushCards($pointsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}


/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsNoDuplicates
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourBCompare(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($pointsNoDuplicates[1], $cardsInHand) ||
        in_array($pointsNoDuplicates[2], $cardsInHand) ||
        in_array($pointsNoDuplicates[3], $cardsInHand) ||
        in_array($pointsNoDuplicates[4], $cardsInHand) ||
        in_array($pointsNoDuplicates[5], $cardsInHand)
    ) {
        $totalPoints = cSFTwo($pointsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}


/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $pointsNoDuplicates
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFlushColourCCompare(
    array $sortPoints,
    array $sortColour,
    array $pointsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($pointsNoDuplicates[2], $cardsInHand) ||
        in_array($pointsNoDuplicates[3], $cardsInHand) ||
        in_array($pointsNoDuplicates[4], $cardsInHand) ||
        in_array($pointsNoDuplicates[5], $cardsInHand) ||
        in_array($pointsNoDuplicates[6], $cardsInHand)
    ) {
        $totalPoints = cSFThree($pointsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsFourOfAKind($sortPoints, $sortColour, $cardsInHand);
}
