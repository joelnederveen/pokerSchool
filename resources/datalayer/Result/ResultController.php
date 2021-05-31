<?php
require(ROOT . "model/EmployeeModel.php");
require(ROOT . "model/CardModel.php");

function result() {
	$conn = openDatabaseConnection();
	$playerQuery = $conn->prepare("SELECT * FROM cardsplayers WHERE id >= (SELECT id FROM cardsplayers WHERE player = 1 ORDER BY id DESC LIMIT 1)");
	$playerQuery->execute();
	$playerCards = $playerQuery->fetchAll();
	$playerQuery->closeCursor();

	$tableQuery = $conn->prepare("SELECT * FROM cardstable ORDER BY id DESC LIMIT 1");
	$tableQuery->execute();
	$tableCards = $tableQuery->fetch();

	$players = array_map(function($a) {
		return Player::fromArray($a);
	}, $playerCards);
	$table = Table::fromArray($tableCards);

	render('result/result', [
		'players' => $players,
		'table' => $table
	]);
}

function bets() {
	$conn = openDatabaseConnection();
	$playerQuery = $conn->prepare("SELECT * FROM cardsplayers WHERE id >= (SELECT id FROM cardsplayers WHERE player = 1 ORDER BY id DESC LIMIT 1)");
	$playerQuery->execute();
	$playerCards = $playerQuery->fetchAll();
	$playerQuery->closeCursor();

	$tableQuery = $conn->prepare("SELECT * FROM cardstable ORDER BY id DESC LIMIT 1");
	$tableQuery->execute();
	$tableCards = $tableQuery->fetch();

	$players = array_map(function($a) {
		return Player::fromArray($a);
	}, $playerCards);
	$table = Table::fromArray($tableCards);

	render('result/bets', [
		'players' => $players,
		'table' => $table
	]);
}

//function test() {
//	$cards = [
//		Card::fromName('QClubs'),
//		Card::fromName('6Hearts'),
//		Card::fromName('6Clubs'),
//		Card::fromName('5Clubs'),
//		Card::fromName('4Clubs'),
//		Card::fromName('3Clubs'),
//		Card::fromName('2Clubs'),
//	];
//
//	echo '<pre>';
////	var_dump(Hand::getStraight(Hand::getFlush($cards)));
//	var_dump(Hand::getNumbers($cards));
//	echo '</pre>';
//}
