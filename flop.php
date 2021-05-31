<?php 
include("resources/datalayer/card/cardcontroller.php");

$data;

$data = cardstable();



?>

<img src="resources/Cards/<?= $data["card1"]?>.jpg" style="width: 175px" alt="image">
<img src="resources/Cards/<?= $data["card2"]?>.jpg" style="width: 175px" alt="image">
<img src="resources/Cards/<?= $data["card3"]?>.jpg" style="width: 175px" alt="image">
<img src="resources/Cards/TurnedCard.jpg" style="width: 175px" alt="image">
<img src="resources/Cards/TurnedCard.jpg" style="width: 175px" alt="image">
<br><br><br><br><br><br>

	<li class="d-inline-block"><a href="/pokerSchool/turn.php"><i>TURN</i></a></li>

