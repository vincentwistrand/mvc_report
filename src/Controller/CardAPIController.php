<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
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

        if (count($deck->getDeck()) === 0) {
            return $this->render('card/api.html.twig', ['api' => null]);
        }

        $drawnCards = $deck->drawCards(1);

        $cardsToJSON = $this->cardsToJson($drawnCards);

        $data = [
            'api' => $cardsToJSON
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/api/deck/draw/number",
     *      name="api-draw-number",
     *      methods={"POST"})
     *
     */
    public function drawCards(
        Request $request,
        SessionInterface $session
    ): Response {
        $deck = $session->get('deck');

        $number = $request->request->get('number');

        if (count($deck->getDeck()) < $number) {
            return $this->render('card/api.html.twig', ['api' => null]);
        }

        $drawnCards = $deck->drawCards($number);

        $cardsToJSON = $this->cardsToJson($drawnCards);

        $data = [
            'api' => $cardsToJSON
        ];

        return $this->render('card/api.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/api/deck/deal/toplayers",
     *      name="card-api-draw-players-cards",
     *      methods={"POST"})
     *
     */
    public function drawCardsToPlayers(
        Request $request,
        SessionInterface $session
    ): Response {
        $session->set('players', array());
        $deck = $session->get('deck');

        $cards = $request->request->get('cards');
        $players = $request->request->get('players');

        if (count($deck->getDeck()) < $players * $cards) {
            return $this->render('card/draw.html.twig', ['title' => null]);
        }

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
    public function cardsToJson(array $cards): string
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
    public function playersToJson(object $deck, int $players, int $cards): string
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
