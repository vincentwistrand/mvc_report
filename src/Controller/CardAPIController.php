<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
        $cardsToJSON = $this->cardsToJson($cards);

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
        $cardsToJSON = $this->cardsToJson($cards);

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

        $cardsToJSON = $this->cardsToJson($drawnCards);

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

        $cardsToJSON = $this->cardsToJson($drawnCards);

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

        $playersToJSON = $this->playersToJson($deck, $players, $cards);

        $data = [
            'api' => $playersToJSON
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
    * Convert array of card objects to json string. 
    * @return string
    */
    function cardsToJson(array $cards): string 
    {
        $cardProperties = [];
        foreach ($cards as $card) {
            $cardProperties[] = $card->getProperties();
        }
    
        $json_pretty = json_encode(json_decode(json_encode($cardProperties)), JSON_PRETTY_PRINT);

        return $json_pretty;
    }

    /**
    * Convert array of player objects to json string. 
    * @return string
    */
    function playersToJson(object $deck, int $players, int $cards): string
    {
        for ($i = 1; $i <= $players; $i++) {
            $drawnCards = $deck->drawCards($cards);
            $newPlayer = new \App\Card\Player($i);
            foreach ($drawnCards as $card) {
                $newPlayer->addCard($card);
            }

            $allPlayers[] = $newPlayer;
        }

        $players = array();

        foreach ($allPlayers as $player) {
            $playerCards = array();
            foreach ($player->getCards() as $card) {
                $playerCards[] = $card->getProperties();
            }
            $playerName = "Player " . $player->getPlayerId();
            $players[$playerName] = $playerCards;
        }
        $json_pretty = json_encode(json_decode(json_encode($players)), JSON_PRETTY_PRINT);

        return $json_pretty;
    }
}
