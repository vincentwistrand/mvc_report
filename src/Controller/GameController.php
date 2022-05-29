<?php

namespace App\Controller;

use App\Card\Player;
use App\Card\Deck;
use App\Card\Card;
use App\Card\Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameController extends AbstractController
{
    /**
     * @Route(
     *      "/game",
     *      name="game",
     *      methods={"GET","HEAD"})
     */
    public function home(SessionInterface $session): Response
    {
        $session->set('game', new Game());
        $game = $session->get('game');
        $game->newRound();

        if (null === $session->get('player_points') or null === $session->get('bank_points')) {
            $session->set('player_points', 0);
            $session->set('bank_points', 0);
        }

        $data = [
            'title' => 'Game',
            'link_to_game_start' => $this->generateUrl('game-start'),
            'link_to_game_doc' => $this->generateUrl('game-doc'),
        ];
        return $this->render('game/home.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game/doc",
     *      name="game-doc",
     *      methods={"GET","HEAD"})
     */
    public function gameDoc(): Response
    {
        $data = [
            'title' => 'Doc',
        ];
        return $this->render('game/doc.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game/start",
     *      name="game-start",
     *      methods={"GET","HEAD"})
     */
    public function startGame(
        SessionInterface $session
    ): Response {
        if (null === $session->get('game')) {
            $session->set('game', new Game());
            $game = $session->get('game');
            $game->newRound();
        }

        $game = $session->get('game');

        $data = getGameInfo($game, $session);

        return $this->render('game/game.html.twig', $data);
    }

    /**
     * @Route(
     *      "/game/start",
     *      name="game-start-post",
     *      methods={"POST"}
     * )
     */
    public function startGamePost(
        Request $request,
        SessionInterface $session
    ): Response {
        $draw  = $request->request->get('draw');
        $stop  = $request->request->get('stop');
        $newRound  = $request->request->get('new_round');
        $reset  = $request->request->get('reset');

        $result = checkInput($draw, $stop, $newRound, $reset, $session);

        if ($result === "player") {
            $this->addFlash("info", "You Win!");
        } elseif ($result === "bank") {
            $this->addFlash("info", "Bank Win!");
        }

        return $this->redirectToRoute('game-start');
    }
}


/**
 * Used in StartGame()
 * @return array<mixed>
 */
function getGameInfo(
    object $game,
    SessionInterface $session
): array {
    $playerHand = $game->getPlayerCards();
    $bankHand = $game->getBankCards();

    $playerHandPoints = $game->getPlayerPoints();
    $bankHandPoints = $game->getBankPoints();

    $playerPoints = $session->get('player_points');
    $bankPoints = $session->get('bank_points');

    $gameEnd = $game->hasGameEnded();

    $data = [
        'title' => 'Kortspel 21',
        'game_end' => $gameEnd,
        'player_hand' => $playerHand,
        'bank_hand' => $bankHand,
        'player_hand_points' => $playerHandPoints,
        'bank_hand_points' => $bankHandPoints,
        'player_points' => $playerPoints,
        'bank_points' => $bankPoints

    ];

    return $data;
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return string
*/
function checkInput(
    mixed $draw,
    mixed $stop,
    mixed $newRound,
    mixed $reset,
    SessionInterface $session
): string {
    $game = $session->get("game") ?? 0;
    $playerPoint = $session->get('player_points');
    $bankPoint = $session->get('bank_points');

    if ($draw) {
        return ifDraw($session);
    } elseif ($stop) {
        return ifStop($session);
    } elseif ($newRound) {
        $session->set('game', new Game());
        $game = $session->get('game');
        $game->newRound();
    } elseif ($reset) {
        $session->set('game', new Game());
        $game = $session->get('game');
        $game->newRound();

        $playerPoint = 0;
        $bankPoint = 0;
        $session->set('player_points', $playerPoint);
        $session->set('bank_points', $bankPoint);
    }
    return "continue";
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return string
*/
function ifDraw(
    SessionInterface $session
): string {
    $game = $session->get("game") ?? 0;
    $playerPoint = $session->get('player_points');
    $bankPoint = $session->get('bank_points');

    $game->drawCardToPlayer();
    $over21Points = $game->checkPlayerPoints();
    if ($over21Points === true) {
        $bankPoint += 1;
        $session->set('bank_points', $bankPoint);
        return "bank";
    }
    if ($game->getPlayerCardCount() >= 3) {
        $game->drawCardsToBank();

        $over21Points = $game->checkBankPoints();
        if ($over21Points === true) {
            $playerPoint += 1;
            $session->set('player_points', $playerPoint);
            return "player";
        }
        if ($game->playerWin() === true) {
            $playerPoint += 1;
            $session->set('player_points', $playerPoint);
            return "player";
        }
        $bankPoint += 1;
        $session->set('bank_points', $bankPoint);
        return "bank";
    }

    return "continue";
}

/**
* Used in method startGamePost() and processes the input from $request.
* @return string
*/
function ifStop(
    SessionInterface $session
): string {
    $game = $session->get("game") ?? 0;
    $playerPoint = $session->get('player_points');
    $bankPoint = $session->get('bank_points');

    $game->drawCardsToBank();
    $over21Points = $game->checkBankPoints();
    if ($over21Points === true) {
        $playerPoint += 1;
        $session->set('player_points', $playerPoint);
        return "player";
    }

    if ($game->playerWin() === true) {
        $playerPoint += 1;
        $session->set('player_points', $playerPoint);
        return "player";
    }
    $bankPoint += 1;
    $session->set('bank_points', $bankPoint);
    return "bank";
}
