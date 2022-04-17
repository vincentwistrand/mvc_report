<?php

namespace App\Helpfunctions;

function check_input($draw, $stop, $new_round, $reset, $session): string
{   
    $game = $session->get("game") ?? 0;
    $player_point = $session->get('player_points');
    $bank_point = $session->get('bank_points');

    if ($draw) {
        $game->drawCardToPlayer();
        $over21Points = $game->checkPlayerPoints();
        if ($over21Points === true) {
            $bank_point += 1;
            $session->set('bank_points', $bank_point);
            return "bank";
        } else {
            if ($game->getPlayerCardCount() >= 3) {
                $game->drawCardsToBank();

                if ($game->playerWin() === true) {
                    $player_point += 1;
                    $session->set('player_points', $player_point);
                    return "player";
                } else {
                    $bank_point += 1;
                    $session->set('bank_points', $bank_point);
                    return "bank";
                }
            }
            return "continue";
        }
    } elseif ($stop) {
        $game->drawCardsToBank();
        $over21Points = $game->checkBankPoints();
        if ($over21Points === true) {
            $player_point += 1;
            $session->set('player_points', $player_point);
            return "player";
        } else {
            if ($game->playerWin() === true) {
                $player_point += 1;
                $session->set('player_points', $player_point);
                return "player";
            } else {
                $bank_point += 1;
                $session->set('bank_points', $bank_point);
                return "bank";
            }
        }
    } elseif ($new_round) {
        $session->set('game', new \App\Card\Game());
        $game = $session->get('game');
        $game->newRound();

        return "continue";

    } elseif ($reset) {
        $session->set('game', new \App\Card\Game());
        $game = $session->get('game');
        $game->newRound();

        $player_point = 0;
        $bank_point = 0;
        $session->set('player_points', $player_point);
        $session->set('bank_points', $bank_point);

        return "continue";

    }
}
