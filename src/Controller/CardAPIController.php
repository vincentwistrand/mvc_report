<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Helpfunctions\console_log;

class CardAPIController extends AbstractController
{
    /**
    * @Route("/card/api/deck", name="api-deck")
    */
    public function sortedAPI(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->sortCards();
        $json = json_encode($deck->getDeck());
        $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);

        $data = [
            'api' => $json_pretty
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
    * @Route("/card/api/deck/shuffle", name="api-shuffle")
    */
    public function shuffleAPI(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->shuffleCards();
        $json = json_encode($deck->getDeck());
        $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);

        $data = [
            'api' => $json_pretty
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
    * @Route("/card/api/deck/draw", name="api-draw")
    */
    public function drawOne(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $drawnCards = $deck->drawCards(1);

        $json = json_encode($drawnCards);
        $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);

        $data = [
            'api' => $json_pretty
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/api/deck/draw/{number}",
     *      name="api-draw-number",
     *      methods={"GET","HEAD"})
     *
     */
    public function drawCards(
        int $number,
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');
        $drawnCards = $deck->drawCards($number);

        $json = json_encode($drawnCards);
        $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);

        $data = [
            'api' => $json_pretty
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/api/deck/deal/{players}/{cards}",
     *      name="card-api-draw-players-cards",
     *      methods={"GET","HEAD"})
     *
     */
    public function drawCardsToPlayers(
        int $players,
        int $cards,
        SessionInterface $session
    ): Response {
        $session->set('players', array());
        $allPlayers = $session->get('players');
        $deck = $session->get('deck');

        for ($i = 1; $i <= $players; $i++) {
            $drawnCards = $deck->drawCards($cards);

            $newPlayer = new \App\Card\Player($i);
            foreach ($drawnCards as $card) {
                $newPlayer->addCard($card);
            }
            
            $allPlayers[] = $newPlayer;
        }

        $json = json_encode($allPlayers);
        $json_pretty = json_encode(json_decode($json), JSON_PRETTY_PRINT);

        $data = [
            'api' => $json_pretty
        ];

        return $this->render('card/api.html.twig', $data);
    }
}
