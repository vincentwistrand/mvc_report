<?php

namespace App\Interface;

interface DeckInterface
{
    /**
     * Get all cards in deck.
     *
     * @return array<object> with all cards in deck.
     */
    public function getDeck();

    /**
     * Create deck.
     *
     * @return void
     */
    public function createDeck();

    /**
     * Sort deck.
     *
     * @return void
     */
    public function sortCards();

    /**
     * Draw a number of cards from the deck.
     *
     * @return array<object> with all drawn cards.
     */
    public function drawCards(int $number);
}
