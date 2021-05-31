<?php

function createDatabaseConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "poker";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e){
        echo "connection failed: " . $e->getMessage();
    }
}

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


function cardstable(){
        
    
    // Open de verbinding met de database
    $conn=createDatabaseConnection();

    // Zet de query klaar door midel van de prepare method. Voeg hierbij een
    // WHERE clause toe (WHERE id = :id. Deze vullen we later in de code
    $stmt = $conn->prepare("SELECT * FROM cardstable ORDER BY id DESC LIMIT 1");
    // Met bindParam kunnen we een parameter binden. Dit vult de waarde op de plaats in
    // We vervangen :id in de query voor het id wat de functie binnen is gekomen.
    $stmt->bindParam(":id", $id);

    // Voer de query uit
    $stmt->execute();

    // Haal alle resultaten op en maak deze op in een array
    // In dit geval weten we zeker dat we maar 1 medewerker op halen (de where clause), 
    //daarom gebruiken we hier de fetch functie.
    $result = $stmt->fetch();
    return $result;




}

function player($id){
    $players = array(
        "1" => 1, "2" => 2, "3" => 3, "4" => 4, "5" => 5, "6" => 6,
        );
    if(
        !isset($players[$id])
    ){
        exit("leuk geprobeerd");
    }
    
    $player = $players[$id];
    $cards = playercards($players[$id]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        $bet = $_POST["bet"];
        raising($bet, $player);
    }

    $bet = betAmount($players[$id]);
    $playercards = array("player" => $player,"cards" => $cards, "bet" => $bet);

    render('employee/player', $playercards);

    // $games = getAllGames();
    // //2. Geef een view weer en geef de variable met medewerkers hieraan mee
    // render('employee/index', $games);
}
function inzetten(){
    $cards = cardstable();


    render('employee/inzetten', $cards);

    // $games = getAllGames();
    // //2. Geef een view weer en geef de variable met medewerkers hieraan mee
    // render('employee/index', $games);
}

function flop(){
    $cards = cardstable();


    render('employee/flop', $cards);

    // $games = getAllGames();
    // //2. Geef een view weer en geef de variable met medewerkers hieraan mee
    // render('employee/index', $games);
}

function river(){
    $cards = cardstable();


    render('employee/river', $cards);

    // $games = getAllGames();
    // //2. Geef een view weer en geef de variable met medewerkers hieraan mee
    // render('employee/index', $games);
}

function turn(){
    $cards = cardstable();


    render('employee/turn', $cards);

    // $games = getAllGames();
    // //2. Geef een view weer en geef de variable met medewerkers hieraan mee
    // render('employee/index', $games);
}
function index(){
    // $shuffledcards = shufflecards();
    render('employee/index');
}


function shufflingCards(){
    $shuffledcards = shufflecards();


    $dbConnection = createDatabaseConnection();
    $stmt = $dbConnection->prepare("INSERT INTO cardsplayers (player, card1, card2) VALUES (:player, :card1, :card2)");
    $stmt->bindParam(":player", $player);
    $stmt->bindParam(":card1", $card1);
    $stmt->bindParam(":card2", $card2);

    for ($i = 0; $i < 6; $i++) {
        $player = $i + 1;
        $card1 = $shuffledcards[0 + $i * 2];
        $card2 = $shuffledcards[1 + $i * 2];

        $stmt->execute();
    }

    $stmt = $dbConnection->prepare("INSERT INTO cardstable (card1, card2, card3, card4, card5) VALUES (:card1, :card2, :card3, :card4, :card5)");
    $stmt->bindParam(":card1", $shuffledcards[12]);
    $stmt->bindParam(":card2", $shuffledcards[13]);
    $stmt->bindParam(":card3", $shuffledcards[14]);
    $stmt->bindParam(":card4", $shuffledcards[15]);
    $stmt->bindParam(":card5", $shuffledcards[16]);
    $stmt->execute();
    
}

function raising($bet, $player){
    $dbConnection = openDatabaseConnection();
    $stmt = $dbConnection->prepare("UPDATE cardsplayers SET bet = :bet WHERE player = :player");
    $stmt->bindParam(":player", $player);
    $stmt->bindParam(":bet", $bet);

    $stmt->execute();
    
}









?>
