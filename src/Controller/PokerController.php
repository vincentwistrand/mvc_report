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
    *       "/proj/pokergame",
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

        $testHandCards = [];
        $testHandCards[] = new Card(
            '',
            'Klover',
            '3'
        );
        $testHandCards[] = new Card(
            '',
            'Ruter',
            '5'
        );

        $newTestHandObject = [];

        foreach ($testHandCards as $card) {
            $newTestHandObject[] = (object) [
                'colour' => $card->getColour(),
                'points' => intval($card->getPoints())
            ];
        }

        $testAllCards = [];
        $testAllCards[] = new Card(
            '',
            'Klover',
            '3'
        );
        $testAllCards[] = new Card(
            '',
            'Hjarter',
            '4'
        );
        $testAllCards[] = new Card(
            '',
            'Ruter',
            '5'
        );
        $testAllCards[] = new Card(
            '',
            'Spader',
            '6'
        );
        $testAllCards[] = new Card(
            '',
            'Spader',
            '7'
        );
        $testAllCards[] = new Card(
            '',
            'Ruter',
            '8'
        );
        $testAllCards[] = new Card(
            '',
            'Hjarter',
            '9'
        );

        $newTestObject = [];
        foreach ($testAllCards as $card) {
            $newTestObject[] = (object) [
                'colour' => $card->getColour(),
                'points' => intval($card->getPoints())
            ];
        }

        //sort by colours
        usort($newTestObject, function ($objectA, $objectB) {
            return strcmp($objectA->colour, $objectB->colour);
        });

        $colour = $newTestObject;

        //sort by points
        usort($newTestObject, function ($objectA, $objectB) {
            return $objectA->points - $objectB->points;
        });
        $points = $newTestObject;
        dump(\App\PokerCalculations\checkHandSevenCards($points, $colour, $newTestHandObject));
        //-----------------------------------------------------------------------

        return $this->render('poker/game.html.twig', $data);
    }

    /**
    * @Route(
    *       "/proj/pokergame",
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
            case 'Restart':
                return $this->redirectToRoute('pokergame');
        }
        return $this->render('poker/game.html.twig', $result[2]);
    }
}
