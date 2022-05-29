<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
*/
function cHSixSix(
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

    if (count($pointsOrderedKeys) === 5) {
        return sixCardsStraightA($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
    }

    if (count($pointsOrderedKeys) === 6) {
        return sixCardsStraightB($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
    }

    return cHSixSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $pointsOrderedKeys
* @param array<object> $objectsNoDuplicates
*/
function sixCardsStraightA(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return cHSixSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $pointsOrderedKeys
* @param array<object> $objectsNoDuplicates
*/
function sixCardsStraightB(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
        $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
    ) {
        $totalPoints = cSTwo($objectsNoDuplicates);
        return $totalPoints;
    }

    return sixCardsStraightC($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $pointsOrderedKeys
* @param array<object> $objectsNoDuplicates
*/
function sixCardsStraightC(
    array $sortPoints,
    $pointsOrderedKeys,
    $objectsNoDuplicates
): int {
    if (
        $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
        $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
        $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
        $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return cHSixSeven($sortPoints);
}
