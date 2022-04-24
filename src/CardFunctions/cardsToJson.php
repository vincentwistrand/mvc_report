<?php

namespace App\CardFunctions;

/**
* Used in CardApiController to convert array of card objects to json string. 
* @return string
*/
function cardsToJson(array $cards): string 
{
    $cardProperties = [];
    foreach ($cards as $card) {
        $cardProperties[] = $card->getProperties();
    }
    
    $json_pretty = json_encode(json_decode(json_encode($cardProperties)), JSON_PRETTY_PRINT);

    return $json_pretty;
}