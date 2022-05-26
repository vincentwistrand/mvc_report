<?php

namespace App\Card;

use App\Card\Player;
use App\Card\Deck;
use App\Card\Card;

class Poker
{
    private Player $bank;
    private Player $player;
    private Player $table;
    private Deck $deck;
    private int $playerBets = 0;
    private int $bankBets = 0;
    private int $pot = 0;
    private bool $gameOver = false;

    /**
    * @return void
    */
    public function newRound(string $player_id): void
    {
        $this->bank = new \App\Card\Player("Bank");
        $this->player = new \App\Card\Player($player_id);
        $this->table = new \App\Card\Player("Table");
        $this->deck = new \App\Card\Deck();
        $this->deck->shuffleCards();
    }

    /**
    * @return object
    */
    public function dealCardsToPlayers(): void
    {
        for ($i = 0; $i < 2; $i++) {
            $card = $this->deck->drawCard();
            $this->bank->addCard($card);
        }

        for ($i = 0; $i < 2; $i++) {
            $card = $this->deck->drawCard();
            $this->player->addCard($card);
        }
    }

    /**
    * @return void
    */
    public function dealOneCardToTable(): void
    {
        $card = $this->deck->drawCard();
        $this->table->addCard($card);
    }

    /**
    * @return void
    */
    public function dealThreeCardsToTable(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $card = $this->deck->drawCard();
            $this->table->addCard($card);
        }
    }

    /**
    * @return int
    */
    public function getPot(): int
    {
        return $this->pot;
    }

    /**
    * @return void
    */
    public function addToPot(int $amount): void
    {
        $this->pot += $amount;
    }

    /**
    * @return array
    */
    public function getBankCards(): array
    {
        return $this->bank->getCards();
    }

    /**
    * @return array
    */
    public function getPlayerCards(): array
    {
        return $this->player->getCards();
    }

    /**
    * @return array
    */
    public function getTableCards(): array
    {
        return $this->table->getCards();
    }

    /**
    * @return array
    */
    public function getTableCardCount(): array
    {
        return count($this->table->getCards());
    }

    /**
    * @return string
    */
    public function getPlayerUsername(): string
    {
        return $this->player->getPlayerId();
    }

    /**
    * @return void
    */
    public function setGameOver(): void
    {
        $this->gameOver = true;
    }

    /**
    * @return bool
    */
    public function getGameOver(): bool
    {
        return $this->gameOver;
    }
}
