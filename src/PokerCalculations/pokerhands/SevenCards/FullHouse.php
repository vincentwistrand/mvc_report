<?php

namespace App\PokerCalculations;

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouse(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseTwo($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseTwo(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseThree($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseThree(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseFour($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseFour(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseFive($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseFive(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseSix($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseSix(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[4]->points === $sortPoints[5]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseSeven($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseSeven(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseEight($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseEight(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseNine($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseNine(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[0], $cardsInHand) ||
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseTen($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseTen(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[4]->points === $sortPoints[5]->points
    ) {
        if (
            in_array($sortPoints[1], $cardsInHand) ||
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFullHouseEleven($sortPoints, $sortColour, $cardsInHand);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
* @param array<object> $cardsInHand
*/
function sevenCardsFullHouseEleven(
    array $sortPoints,
    array $sortColour,
    array $cardsInHand
): int {
    // Full house
    if (
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points &&
        $sortPoints[5]->points === $sortPoints[6]->points
    ) {
        if (
            in_array($sortPoints[2], $cardsInHand) ||
            in_array($sortPoints[3], $cardsInHand) ||
            in_array($sortPoints[4], $cardsInHand) ||
            in_array($sortPoints[5], $cardsInHand) ||
            in_array($sortPoints[6], $cardsInHand)
        ) {
            $totalPoints = checkFullHouseCards($sortPoints);
            return $totalPoints;
        }
    }
    return sevenCardsFlush($sortPoints, $sortColour, $cardsInHand);
}
