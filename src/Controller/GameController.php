<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Helpfunctions\console_log;

class GameController extends AbstractController
{
    /**
     * @Route(
     *      "/game",
     *      name="game",
     *      methods={"GET","HEAD"})
     */
    public function home(): Response
    {
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
        ): Response
    {   
        if (null === $session->get('game')) {
            $session->set('game', new \App\Card\Game());
            $game = $session->get('game');

            $game = new \App\Card\Game();
            $bank = new \App\Card\Player("Bank");
            $player = new \App\Card\Player("Player");
            $deck = new \App\Card\Deck();

            $game->setBank($bank);
            $game->setPlayer($player);
            $game->setDeck($deck);
        }

        $game = $session->get('game');

        //\App\Functions\console_log($game->getBankId());

        $player_hand = $game->getPlayerCards();
        $player_points = $game->getPlayerPoints();
        $drawCount = $game->getPlayerCardCount();

        $data = [
            'title' => 'Kortspel 21',
            'number_of_draws' => $drawCount,
            'player_hand' => $player_hand,
            'player_points' => $player_points
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
    public function sessionProcess(
        Request $request,
        SessionInterface $session
    ): Response {
        $draw  = $request->request->get('draw');
        $stop  = $request->request->get('stop');

        $game = $session->get("game") ?? 0;

        if ($draw) {
            $card = $game->$this->deck->drawCards(1);
            $game->set

            $cardPoints = $card->$this->points;



            $this->addFlash("error", "You rolled 1 and looses your points.");
            $this->addFlash("info", "You saved $sum points.");

        } elseif ($stop) {
            $this->addFlash("info", "You saved $sum points.");
            $saved += $sum;
            $sum = 0;
            $session->set("saved", $saved);
            $session->set("sum", 0);
        }

        $this->addFlash("info", "You have currently $sum points (not saved).");
        $this->addFlash("info", "You have currently $saved saved points.");

        return $this->redirectToRoute('form-session');
    }
}
