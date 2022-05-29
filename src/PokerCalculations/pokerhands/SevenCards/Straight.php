<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSevenSix(
    array $sortPoints
): int {
    // Straight
    $pointsArray = [];

    foreach ($sortPoints as $card) {
        $pointsArray[] = $card->points;
    }

    $pointsNoDuplicates = array_unique($pointsArray);

    $pointsOrderedKeys = [];

    foreach ($pointsNoDuplicates as $points) {
        $pointsOrderedKeys[] = $points;
    }

    $objectsNoDuplicates = [];

    $goneThroughtPoints = [];

    foreach ($sortPoints as $card) {
        if (in_array($card->points, $pointsOrderedKeys) && in_array($card->points, $goneThroughtPoints) === false) {
            $objectsNoDuplicates[] = $card;
            $goneThroughtPoints[] = $card->points;
        }
    }

    return cHSevenSixA($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
*/
function cHSevenSixA(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (
        count($pointsOrderedKeys) === 5 ||
        count($pointsOrderedKeys) === 6 ||
        count($pointsOrderedKeys) === 7
    ) {
        if (
            $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
        ) {
            $totalPoints = checkStraightCards($objectsNoDuplicates);
            return $totalPoints;
        }
    }

    return cHSevenSixB($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
*/
function cHSevenSixB(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (
        count($pointsOrderedKeys) === 6 ||
        count($pointsOrderedKeys) === 7
    ) {
        if (
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
            $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
        ) {
            $totalPoints = cSTwo($objectsNoDuplicates);
            return $totalPoints;
        }
    }

    return cHSevenSixC($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
*/
function cHSevenSixC(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (count($pointsOrderedKeys) === 7) {
        if (
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
            $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
            $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1)
        ) {
            $totalPoints = cSTwo($objectsNoDuplicates);
            return $totalPoints;
        }
    }

    return cHSevenSeven($sortPoints);
}
