<?php

namespace App\Controller;

use App\Card\Player;
use App\Card\Deck;
use App\Card\Card;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardController extends AbstractController
{
    /**
    * @Route("/card", name="card")
    */
    public function home(SessionInterface $session): Response
    {
        if (null === $session->get('deck')) {
            $session->set('deck', new Deck());
            $deck = $session->get('deck');
            $deck->createDeck();
        }

        //\App\Functions\console_log($deckApi->getDeck());

        $data = [
            'title' => 'Landningssida för kortlek',
            'link_to_card_deck' => $this->generateUrl('card-deck'),
            'link_to_card_shuffle' => $this->generateUrl('card-shuffle'),
            'link_to_card_draw' => $this->generateUrl('card-draw'),
            'link_to_draw_cards' => $this->generateUrl('card-draw-number'),
            'link_to_draw_to_players' => $this->generateUrl('card-draw-players-cards'),
            'link_to_card_deck2' => $this->generateUrl('card-deck2'),
            'link_to_card_api' => $this->generateUrl('api-deck'),
            'link_to_card_api_shuffle' => $this->generateUrl('api-shuffle'),
            'link_to_card_api_draw' => $this->generateUrl('api-draw'),
            'link_to_api_draw_number' => $this->generateUrl('api-draw-number'),
            'link_to_card_api_draw_players_cards' => $this->generateUrl('card-api-draw-players-cards')
        ];

        return $this->render('card/home.html.twig', $data);
    }

    /**
    * @Route("/card/deck", name="card-deck")
    */
    public function allOrdered(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->sortCards();

        $data = [
            'title' => 'Kortleken är sorterad',
            'deck' => $deck->getDeck(),
            'deck_count' => count($deck->getDeck())
        ];

        return $this->render('card/all_cards.html.twig', $data);
    }

    /**
    * @Route("/card/deck2", name="card-deck2")
    */
    public function deck2Ordered(SessionInterface $session): Response
    {
        $session->set('deck', new Deck());
        $deck = $session->get('deck');
        $deck->createDeck();
        $deck->addJokers();

        $data = [
            'title' => 'Kortleken återställd och två jokrar tillagda',
            'deck' => $deck->getDeck(),
            'deck_count' => count($deck->getDeck())
        ];

        return $this->render('card/all_cards.html.twig', $data);
    }

    /**
    * @Route("/card/deck/shuffle", name="card-shuffle")
    */
    public function shuffle(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        $deck->shuffleCards();

        $data = [
            'title' => 'Kortleken är återställd och blandad',
            'deck' => $deck->getDeck(),
            'deck_count' => count($deck->getDeck())
        ];

        return $this->render('card/all_cards.html.twig', $data);
    }

    /**
    * @Route("/card/deck/draw", name="card-draw")
    */
    public function drawOne(SessionInterface $session): Response
    {
        $deck = $session->get('deck');
        if (count($deck->getDeck()) === 0) {
            return $this->render('card/draw.html.twig', ['title' => null]);
        }
        $drawnCards = $deck->drawCards(1);
        $cardsLeft = count($deck->getDeck());

        $data = [
            'title' => 'Dragna kort',
            'drawn_cards' => $drawnCards,
            'cards_left' => $cardsLeft
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/deck/draw/number",
     *      name="card-draw-number",
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
            return $this->render('card/draw.html.twig', ['title' => null]);
        }

        $drawnCards = $deck->drawCards($number);
        $cardsLeft = count($deck->getDeck());

        $data = [
            'title' => 'Dragna kort',
            'drawn_cards' => $drawnCards,
            'cards_left' => $cardsLeft
        ];

        return $this->render('card/draw.html.twig', $data);
    }

    /**
     * @Route(
     *      "/card/deck/deal/toplayers",
     *      name="card-draw-players-cards",
     *      methods={"POST"})
     *
     */
    public function drawCardsToPlayers(
        Request $request,
        SessionInterface $session
    ): Response {
        $session->set('players', array());
        $allPlayers = $session->get('players');
        $deck = $session->get('deck');

        $cards = $request->request->get('cards');
        $players = $request->request->get('players');

        if (count($deck->getDeck()) < $players * $cards) {
            return $this->render('card/draw.html.twig', ['title' => null]);
        }

        for ($i = 1; $i <= $players; $i++) {
            $drawnCards = $deck->drawCards($cards);

            $newPlayer = new Player(strval($i));
            foreach ($drawnCards as $card) {
                $newPlayer->addCard($card);
            }

            $allPlayers[] = $newPlayer;
        }

        $cardsLeft = count($deck->getDeck());

        $data = [
            'title' => 'Spelare med respektive kort',
            'all_players' => $allPlayers,
            'cards_left' => $cardsLeft
        ];

        return $this->render('card/players.html.twig', $data);
    }
}
