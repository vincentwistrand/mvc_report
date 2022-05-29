<?php

namespace App\PokerCalculations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
* Check card hand with three cards and return points
* @return int
* @param array<object> $sortPoints
*/
function checkHandThreeCards(
    array $sortPoints
): int {
    // Three of a kind
    if ($sortPoints[0]->points === $sortPoints[1]->points && $sortPoints[1]->points === $sortPoints[2]->points) {
        $totalPoints = checkThreeOfAKindCards($sortPoints);
        return $totalPoints;
    }

    // Pair
    if ($sortPoints[0]->points === $sortPoints[1]->points || $sortPoints[1]->points === $sortPoints[2]->points) {
        $totalPoints = checkPairCards($sortPoints);
        return $totalPoints;
    }

    return 0;
}
