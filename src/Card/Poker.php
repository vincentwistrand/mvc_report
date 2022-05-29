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
    private int $pot = 0;
    private bool $gameOver = false;

    /**
    * @return void
    */
    public function newRound(string $playerId): void
    {
        $this->bank = new Player("Bank");
        $this->player = new Player($playerId);
        $this->table = new Player("Table");
        $this->deck = new Deck();
        $this->deck->shuffleCards();
    }

    /**
    * @return void
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
    * @return array<object>
    */
    public function getBankCards(): array
    {
        return $this->bank->getCards();
    }

    /**
    * @return array<object>
    */
    public function getPlayerCards(): array
    {
        return $this->player->getCards();
    }

    /**
    * @return array<object>
    */
    public function getTableCards(): array
    {
        return $this->table->getCards();
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
    public function hasGameEnded(): bool
    {
        return $this->gameOver;
    }
}
