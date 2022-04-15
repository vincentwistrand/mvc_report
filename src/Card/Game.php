<?php

namespace App\Card;

class Game
{
    private $bank;
    private $player;
    private $deck;

    public function setBank(object $bank): void
    {
        $this->bank = $bank;
    }

    public function setPlayer(object $player): void
    {   
        $this->player = $player;
    }

    public function setDeck(object $deck): void
    {   
        $this->deck = $deck;
    }

    public function drawCardFromDeck(): object
    {   
        return $this->deck->drawCards(1);
    }

    public function addPlayerCard(object $card): void
    {   
        $this->player->addCard($card);
    }

    public function addPlayerPoints(int $points): void
    {   
        $this->player->addPoints($points);
    }

    public function getPlayerCardCount(): int
    {   
        return $this->player->getCardCount();
    }

    public function getBankCards(): string
    {   
        return $this->bank->getCards();
    }

    public function getPlayerId(): string
    {   
        return $this->player->player_id;
    }

    public function getPlayerCards(): array
    {   
        return $this->player->getCards();
    }

    public function getPlayerPoints(): int
    {   
        return $this->player->getPoints();
    }
}