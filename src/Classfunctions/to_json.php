<?php

namespace App\Classfunctions;

function to_json(array $cards): string {
    $cardAttributes = [];

    foreach ($cards as $card) {
        $cardAttributes[] = $card->getAttributes();
    }
    
    $json_pretty = json_encode(json_decode(json_encode($cardAttributes)), JSON_PRETTY_PRINT);

    return $json_pretty;
}