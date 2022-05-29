<?php

namespace App\Controller;

use App\Card\Poker;
use App\Card\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\PokerUser;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PokerUserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PokerController extends AbstractController
{
    /**
    * @Route(
    *       "/pokergame",
    *       name="pokergame",
    *       methods={"GET","HEAD"}
    * )
    */
    public function pokerGame(
        SessionInterface $session
    ): Response {
        $session->set('PokerGame', new Poker());
        $game = $session->get('PokerGame');
        $user = $session->get('CurrentPokerUser');
        $game->newRound($user->getUsername());

        $session->set('PokerComment', '');
        $session->set('BankMove', '');
        $session->set('PlayerMove', '');

        $data = \App\PokerCalculations\getPokerGameInfo($game, $user, $session);

        //Testing-----------------------------------------------------

        //$testCards = [];
        //$testCards[] = new Card(
        //    '',
        //    'Hjarter',
        //    '10'
        //);
        //$testCards[] = new Card(
        //    '',
        //    'Hjarter',
        //    '5'
        //);
        //$testCards[] = new Card(
        //    '',
        //    'Ruter',
        //    '11'
        //);
        //$testCards[] = new Card(
        //    '',
        //    'Hjarter',
        //    '12'
        //);
        //$testCards[] = new Card(
        //    '',
        //    'Ruter',
        //    '13'
        //);
        //$testCards[] = new Card(
        //    '',
        //    'Hjarter',
        //    '9'
        //);

        //$newTestObject = [];

        //foreach ($testCards as $card) {
        //    $newTestObject[] = (object) [
        //        'colour' => $card->getColour(),
        //        'points' => intval($card->getPoints())
        //    ];
        //}

        ////sort by colours
        //usort($newTestObject, function ($objectA, $objectB) {
        //    return strcmp($objectA->colour, $objectB->colour);
        //});

        //$colour = $newTestObject;

        ////sort by points
        //usort($newTestObject, function ($objectA, $objectB) {
        //    return $objectA->points - $objectB->points;
        //});

        //$points = $newTestObject;


        //dump(\App\PokerCalculations\checkHandSixCards($points, $colour));

        //-----------------------------------------------------------------------

        return $this->render('poker/game.html.twig', $data);
    }

    /**
    * @Route(
    *       "/pokergame",
    *       name="pokergame_post",
    *       methods={"POST"}
    * )
    */
    public function pokerGamePost(
        SessionInterface $session,
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $result = \App\PokerCalculations\managePokerGame($session, $request, $doctrine);

        switch ($result[0]) {
            case 'Deal cards':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Fold':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Restart':
                return $this->redirectToRoute('pokergame');
            case 'Bet 10$':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Raise 10$':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Re-raise 10$':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Check':
                return $this->render('poker/game.html.twig', $result[2]);
            case 'Call':
                return $this->render('poker/game.html.twig', $result[2]);
        }
        return $this->redirectToRoute('pokergame');
    }
}
