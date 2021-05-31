<style>
    img {
        width: 90px;
    }

    .centered {
        text-align: center;
    }
</style>

<hr>

<div class="centered">
	<?php

	/** @var Table $table */
	foreach ($table->cards as $card) {
		?>
        <img src="resources/<?php echo $card->getImage(); ?>" alt="Kaart">
		<?php
	}

	?>
</div>

<hr>

<table style="width: 100%;">
    <tr>
        <th>Speler</th>
        <th>Kaarten</th>
        <th>Resultaat</th>
        <th>Score</th>
        <th>High card</th>
        <th>bets</th>
    </tr>
	<?php

	/** @var Player[] $players */
    $som = 0;
    foreach ($players as $player) {
	    $hand = $player->getHand($table);
        $som += $player->bet;
		?>
        <tr>
            <td><?php echo $player->number; ?></td>
            <td>
				<?php

				foreach ($player->cards as $card) {
					?>
                    <img src="/poker/public<?php echo $card->getImage(); ?>" alt="Kaart">
					<?php
				}

				?>
            </td>
            <td>
                <?php echo $hand->result; ?>
            </td>
            <td>
                <?php echo $hand->score; ?>
            </td>
            <td>
                <?php echo $hand->highCard; ?>
            </td>
            <td>
                <?php echo $player->bet; ?>
            </td>
        </tr>
		<?php
	} ?>
<tr>
<td></td><td></td><td><td></td><td></td>
<th>
 <?php echo $som; ?> 
</th>
</tr>

</table>

<br><br><br><br><br><br>
    <li class="d-inline-block"><a href="/pokerSchool/inzetten.php"><i>INZETTEN</i></a></li>
