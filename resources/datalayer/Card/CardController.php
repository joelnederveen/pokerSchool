<?php

include("cardModel.php");


Function shufflecards(){
    $cards = [
        '10Clubs',
        '10Diamonds',
        '10Hearts',
        '10Spades',
        '2Clubs',
        '2Diamonds',
        '2Hearts',
        '2Spades',
        '3Clubs',
        '3Diamonds',
        '3Hearts',
        '3Spades',
        '4Clubs',
        '4Diamonds',
        '4Hearts',
        '4Spades',
        '5Clubs',
        '5Diamonds',
        '5Hearts',
        '5Spades',
        '6Clubs',
        '6Diamonds',
        '6Hearts',
        '6Spades',
        '7Clubs',
        '7Diamonds',
        '7Hearts',
        '7Spades',
        '8Clubs',
        '8Diamonds',
        '8Hearts',
        '8Spades',
        '9Clubs',
        '9Diamonds',
        '9Hearts',
        '9Spades',
        'AClubs',
        'ADiamonds',
        'AHearts',
        'ASpades',
        'JClubs',
        'JDiamonds',
        'JHearts',
        'JSpades',
        'KClubs',
        'KDiamonds',
        'KHearts',
        'KSpades',
        'QClubs',
        'QDiamonds',
        'QHearts',
        'QSpades',
    ];

    shuffle($cards);
    return $cards;
}





function player($id){
    
    $player = $id;
    $cards = playercards($id);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $bet = $_POST["bet"];
        raising($bet, $player);
    }

    $bet = betAmount($players[$id]);
    $playercards = array("player" => $player,"cards" => $cards, "bet" => $bet);

    return $playercards;


}


?>
