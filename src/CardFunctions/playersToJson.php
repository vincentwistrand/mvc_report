<?php

namespace App\CardFunctions;

/**
* Used in CardApiController to convert array of player objects containing card objects to json string. 
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
