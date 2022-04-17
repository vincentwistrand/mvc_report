<?php

namespace App\Interface;

interface Deck2Interface
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

    /**
     * Add two jokers to the deck.
     *
     * @return void
     */
    public function addJokers();
}
