<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\CardFunctions\checkInput;

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
        $session->set('game', new \App\Card\Game());
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
            $session->set('game', new \App\Card\Game());
            $game = $session->get('game');
            $game->newRound();
        }

        $game = $session->get('game');

        $player_hand = $game->getPlayerCards();
        $bank_hand = $game->getBankCards();

        $player_hand_points = $game->getPlayerPoints();
        $bank_hand_points = $game->getBankPoints();

        $player_points = $session->get('player_points');
        $bank_points = $session->get('bank_points');

        $gameEnd = $game->getGameEnd();

        //\App\Helpfunctions\console_log($player_points);

        $data = [
            'title' => 'Kortspel 21',
            'game_end' => $gameEnd,
            'player_hand' => $player_hand,
            'bank_hand' => $bank_hand,
            'player_hand_points' => $player_hand_points,
            'bank_hand_points' => $bank_hand_points,
            'player_points' => $player_points,
            'bank_points' => $bank_points

        ];
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
        $new_round  = $request->request->get('new_round');
        $reset  = $request->request->get('reset');

        $result = \app\CardFunctions\checkInput($draw, $stop, $new_round, $reset, $session);

        if ($result === "player") {
            $this->addFlash("info", "You Win!");
        } elseif ($result === "bank") {
            $this->addFlash("info", "Bank Win!");
        }

        return $this->redirectToRoute('game-start');
    }
}
