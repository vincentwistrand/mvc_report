<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $cardsInHand
*/
function sevenCardsStraight(
    array $sortPoints,
    array $cardsInHand
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

    return sevenCardsStraightOne($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightOne(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        count($pointsOrderedKeys) === 5
    ) {
        if (
            $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
        ) {
            return includesStartCardsOne(
                $sortPoints,
                $pointsOrderedKeys,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsStraightTwo($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function includesStartCardsOne(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[0], $cardsInHand) ||
        in_array($objectsNoDuplicates[1], $cardsInHand) ||
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsStraightTwo($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightTwo(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        count($pointsOrderedKeys) === 6
    ) {
        if (
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
            $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
        ) {
            return includesStartCardsTwo(
                $sortPoints,
                $pointsOrderedKeys,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsStraightThree($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function includesStartCardsTwo(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[1], $cardsInHand) ||
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand) ||
        in_array($objectsNoDuplicates[5], $cardsInHand)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsStraightThree($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightThree(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        count($pointsOrderedKeys) === 6
    ) {
        if (
            $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
        ) {
            return includesStartCardsThree(
                $sortPoints,
                $pointsOrderedKeys,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsStraightFour($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function includesStartCardsThree(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[0], $cardsInHand) ||
        in_array($objectsNoDuplicates[1], $cardsInHand) ||
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsStraightFour($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFour(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (count($pointsOrderedKeys) === 7) {
        if (
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
            $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1) &&
            $pointsOrderedKeys[6] === ($pointsOrderedKeys[5] + 1)
        ) {
            dump('båt');
            return includesStartCardsFour(
                $sortPoints,
                $pointsOrderedKeys,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsStraightFive($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function includesStartCardsFour(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand) ||
        in_array($objectsNoDuplicates[5], $cardsInHand) ||
        in_array($objectsNoDuplicates[6], $cardsInHand)
    ) {
        $totalPoints = cSThree($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsStraightFive($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightFive(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (count($pointsOrderedKeys) === 7) {
        if (
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1) &&
            $pointsOrderedKeys[5] === ($pointsOrderedKeys[4] + 1)
        ) {
            return includesStartCardsFive(
                $sortPoints,
                $pointsOrderedKeys,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsStraightSix($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function includesStartCardsFive(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[1], $cardsInHand) ||
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand) ||
        in_array($objectsNoDuplicates[5], $cardsInHand)
    ) {
        $totalPoints = cSTwo($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsStraightSix($sortPoints, $pointsOrderedKeys, $objectsNoDuplicates, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<int> $pointsOrderedKeys
* @param array<object> $cardsInHand
*/
function sevenCardsStraightSix(
    array $sortPoints,
    array $pointsOrderedKeys,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (count($pointsOrderedKeys) === 7) {
        if (
            $pointsOrderedKeys[1] === ($pointsOrderedKeys[0] + 1) &&
            $pointsOrderedKeys[2] === ($pointsOrderedKeys[1] + 1) &&
            $pointsOrderedKeys[3] === ($pointsOrderedKeys[2] + 1) &&
            $pointsOrderedKeys[4] === ($pointsOrderedKeys[3] + 1)
        ) {
            return includesStartCardsSix(
                $sortPoints,
                $objectsNoDuplicates,
                $cardsInHand
            );
        }
    }

    return sevenCardsThreeOfAKind($sortPoints, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $objectsNoDuplicates
* @param array<object> $cardsInHand
*/
function includesStartCardsSix(
    array $sortPoints,
    array $objectsNoDuplicates,
    array $cardsInHand
): int {
    if (
        in_array($objectsNoDuplicates[0], $cardsInHand) ||
        in_array($objectsNoDuplicates[1], $cardsInHand) ||
        in_array($objectsNoDuplicates[2], $cardsInHand) ||
        in_array($objectsNoDuplicates[3], $cardsInHand) ||
        in_array($objectsNoDuplicates[4], $cardsInHand)
    ) {
        $totalPoints = checkStraightCards($objectsNoDuplicates);
        return $totalPoints;
    }

    return sevenCardsThreeOfAKind($sortPoints, $cardsInHand);
}
