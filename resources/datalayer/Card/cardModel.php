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


function playercards($id){
        
    // Open de verbinding met de database
    $conn=openDatabaseConnection();

    // Zet de query klaar door midel van de prepare method. Voeg hierbij een
    // WHERE clause toe (WHERE id = :id. Deze vullen we later in de code
    $stmt = $conn->prepare("SELECT * FROM cardsplayers WHERE player = :id ORDER BY id DESC LIMIT 1");
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

function cardstable(){
        
    // Open de verbinding met de database
    $conn=openDatabaseConnection();

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

function betAmount($id){

    
    // Open de verbinding met de database
    $conn=openDatabaseConnection();

    // Zet de query klaar door midel van de prepare method. Voeg hierbij een
    // WHERE clause toe (WHERE id = :id. Deze vullen we later in de code
    $stmt = $conn->prepare("SELECT bet FROM cardsplayers WHERE player = :id ORDER BY id DESC LIMIT 1");
    // Met bindParam kunnen we een parameter binden. Dit vult de waarde op de plaats in
    // We vervangen :id in de query voor het id wat de functie binnen is gekomen.
    $stmt->bindParam(":id", $id);

    // Voer de query uit
    $stmt->execute();
    
    // Haal alle resultaten op en maak deze op in een array
    // In dit geval weten we zeker dat we maar 1 medewerker op halen (de where clause), 
    //daarom gebruiken we hier de fetch functie.
    $result = $stmt->fetch();
    
    return $result['bet'];

    


}
?>

