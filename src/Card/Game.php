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
    * @return void
    */
    public function drawCardToPlayer(): void
    {
        $card = $this->deck->drawCard();
        $this->player->addCard($card);
        $this->playerPoints += intval($card->getPoints());
    }

    /**
    * @return void
    */
    public function drawCardsToBank(): void
    {
        $card = $this->deck->drawCard();
        $this->bank->addCard($card);
        $this->bankPoints += intval($card->getPoints());

        if ($this->bankPoints <= 21) {
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
            $this->bankPoints += intval($card->getPoints());

            if ($this->bankPoints <= 17) {
                $card = $this->deck->drawCard();
                $this->bank->addCard($card);
                $this->bankPoints += intval($card->getPoints());
            }
        }
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
    * @return void
    */
    public function addCardToPlayerHand(object $card): void
    {
        $this->player->addCard($card);
    }

    /**
    * @return void
    */
    public function addCardToBankHand(object $card): void
    {
        $this->bank->addCard($card);
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
