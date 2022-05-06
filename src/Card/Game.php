<?php

namespace App\Card;

use App\Card\Player;
use App\Card\Deck;
use App\Card\Card;

class Game
{
    private Player $bank;
    private Player $player;
    private Deck $deck;
    private int $playerPoints = 0;
    private int $bankPoints = 0;
    private bool $gameEnd = false;

    /**
    * @return void
    */
    public function newRound(): void
    {
        $this->bank = new \App\Card\Player("Bank");
        $this->player = new \App\Card\Player("Player");
        $this->deck = new \App\Card\Deck();
        $this->deck->shuffleCards();
    }

    /**
    * @return object
    */
    public function drawCardToPlayer(): object
    {
        $card = $this->deck->drawCard();
        $this->player->addCard($card);
        $this->playerPoints += intval($card->getPoints());

        return $card;
    }

    /**
    * @return array<object>
    */
    public function drawCardsToBank(): array
    {
        $cards = array();

        for ($i = 0; $i < 2; $i++) {
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
            $this->bankPoints += intval($card->getPoints());
            $cards[] = $card;
        }

        if ($this->bankPoints <= 17) {
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
            $this->bankPoints += intval($card->getPoints());
            $cards[] = $card;
        }

        return $cards;
    }

    /**
    * @return bool
    */
    public function checkPlayerPoints(): bool
    {
        if ($this->playerPoints > 21) {
            $this->gameEnd = true;
            return true;
        }
        return false;
    }

    /**
    * @return bool
    */
    public function checkBankPoints(): bool
    {
        if ($this->bankPoints > 21) {
            $this->gameEnd = true;
            return true;
        }
        return false;
    }

    /**
    * @return bool
    */
    public function playerWin(): bool
    {
        $this->gameEnd = true;
        if ($this->playerPoints > $this->bankPoints) {
            return true;
        }
        return false;
    }

    /**
    * @return bool
    */
    public function getGameEnd(): bool
    {
        return $this->gameEnd;
    }

    /**
    * @return array<object>
    */
    public function getDeckCards(): array
    {
        return $this->deck->getDeck();
    }

    /**
    * @return int
    */
    public function getPlayerCardCount(): int
    {
        return $this->player->getCardCount();
    }

    /**
    * @return array<object>
    */
    public function getPlayerCards(): array
    {
        return $this->player->getCards();
    }

    /**
    * @return int
    */
    public function getPlayerPoints(): int
    {
        return $this->playerPoints;
    }

    /**
    * @return array<object>
    */
    public function getBankCards(): array
    {
        return $this->bank->getCards();
    }

    /**
    * @return int
    */
    public function getBankPoints(): int
    {
        return $this->bankPoints;
    }
}
