<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Classfunctions\to_json;
use App\Classfunctions\player_to_json;

class CardAPIController extends AbstractController
{
    /**
    * @Route("/card/api/deck", name="api-deck")
    */
    public function sortedAPI(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->sortCards();

        $cards = $deck->getDeck();
        $cardsToJSON = \app\classfunctions\to_json($cards);

        $data = [
            'api' => $cardsToJSON
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

        $cards = $deck->getDeck();
        $cardsToJSON = \app\classfunctions\to_json($cards);

        $data = [
            'api' => $cardsToJSON
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

        $cardsToJSON = \app\classfunctions\to_json($drawnCards);

        $data = [
            'api' => $cardsToJSON
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

        $cardsToJSON = \app\classfunctions\to_json($drawnCards);

        $data = [
            'api' => $cardsToJSON
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

        $playersToJSON = \app\classfunctions\players_to_json($deck, $players, $cards);

        $data = [
            'api' => $playersToJSON
        ];

        return $this->render('card/api.html.twig', $data);
    }
}
