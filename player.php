<?php 
include("resources/datalayer/card/cardcontroller.php");

$id = $_GET["id"];
$data;
$data = player($id);

?>

<img src="resources/Cards/<?= $data["cards"]["card1"]?>.jpg" class="w-50 float-left" alt="image">
<img src="resources/Cards/<?= $data["cards"]["card2"]?>.jpg" class="w-50 float-right"alt="image">

<form name="create" method="post" action= "" >

<input type="number" name="bet" placeholder="Jouw inzet: <?php echo $data["cards"]["bet"]; ?>">

<input type="Submit" value="Submit">

</form>

<?php
		
?>