<?php

namespace App\PokerCalculations;

/**
* Check card hand with five cards and return points
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function checkHandFiveCards(
    array $sortPoints,
    array $sortColour
): int {
    // Royal flush first part
    if (
        $sortPoints[1]->points === ($sortPoints[0]->points + 1) &&
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1)
    ) {
        return checkHandFiveCardsPartTwo($sortPoints, $sortColour);
    }
    return cHFiveTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function checkHandFiveCardsPartTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Royal flush second part
    if (
        $sortPoints[0]->colour === $sortPoints[1]->colour && $sortPoints[1]->colour === $sortPoints[2]->colour &&
        $sortPoints[2]->colour === $sortPoints[3]->colour && $sortPoints[3]->colour === $sortPoints[4]->colour &&
        $sortPoints[4]->points === 14
    ) {
        return 1000;
    }
    return cHFiveTwo($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHFiveTwo(
    array $sortPoints,
    array $sortColour
): int {
    // Straight flush
    if (
        $sortPoints[1]->points === ($sortPoints[0]->points + 1) &&
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1) &&
        $sortPoints[0]->colour === $sortPoints[1]->colour &&
        $sortPoints[1]->colour === $sortPoints[2]->colour &&
        $sortPoints[2]->colour === $sortPoints[3]->colour &&
        $sortPoints[3]->colour === $sortPoints[4]->colour
    ) {
        $totalPoints = checkStraightFlushCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveThree($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHFiveThree(
    array $sortPoints,
    array $sortColour
): int {
    // Four of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkFourOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveFour($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHFiveFour(
    array $sortPoints,
    array $sortColour
): int {
    // Full house
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points &&
        $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkFullHouseCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveFive($sortPoints, $sortColour);
}

/**
* @return int
* @param array<object> $sortPoints
* @param array<object> $sortColour
*/
function cHFiveFive(
    array $sortPoints,
    array $sortColour
): int {
    // Flush
    if ($sortColour[0]->colour === $sortColour[4]->colour) {
        $totalPoints = checkFlushCards($sortPoints, $sortColour);
        return $totalPoints;
    }
    return cHFiveSix($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFiveSix(
    array $sortPoints
): int {
    // Straight
    if (
        $sortPoints[1]->points === ($sortPoints[0]->points + 1) &&
        $sortPoints[2]->points === ($sortPoints[1]->points + 1) &&
        $sortPoints[3]->points === ($sortPoints[2]->points + 1) &&
        $sortPoints[4]->points === ($sortPoints[3]->points + 1)
    ) {
        $totalPoints = checkStraightCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveSeven($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFiveSeven(
    array $sortPoints
): int {
    // Three of a kind
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveEight($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFiveEight(
    array $sortPoints
): int {
    // Two pairs
    if (
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[2]->points === $sortPoints[3]->points ||
        $sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[3]->points === $sortPoints[4]->points ||
        $sortPoints[1]->points === $sortPoints[2]->points && $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkTwoPairsCards($sortPoints);
        return $totalPoints;
    }
    return cHFiveNine($sortPoints);
}

/**
* @return int
* @param array<object> $sortPoints
*/
function cHFiveNine(
    array $sortPoints
): int {
    // Pair
    if (
        $sortPoints[0]->points === $sortPoints[1]->points || $sortPoints[1]->points === $sortPoints[2]->points ||
        $sortPoints[2]->points === $sortPoints[3]->points || $sortPoints[3]->points === $sortPoints[4]->points
    ) {
        $totalPoints = checkPairCards($sortPoints);
        return $totalPoints;
    }

    $cardPoints = 0;
    foreach ($sortPoints as $card) {
        $cardPoints += $card->points;
    }

    return $cardPoints;
}
