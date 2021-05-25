<?php

function createDatabaseConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "week_4";

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

// read tittles from all the subjects
function readCharacters(){
    $dbConnection = createDatabaseConnection();
    $stmt = $dbConnection->prepare("SELECT *  FROM characters");
    $stmt->execute();
    $result = $stmt->fetchAll();
    $dbConnection = null;
    return $result;
}

function readCharacter($id){
    $dbConnection = createDatabaseConnection();
    $stmt = $dbConnection->prepare("SELECT * FROM characters WHERE id=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $result = $stmt->fetch();
    $dbConnection = null;
    return $result;
}

?>