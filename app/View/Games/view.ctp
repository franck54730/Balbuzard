<!-- File: /app/View/Games/lobby.ctp -->
<h1>Partie : <?php echo $game['nom']?></h1>
<table>
	<tr>
		<th>Joueurs</th>
	</tr>
	<?php 
		foreach($users as $user){
			echo "<tr>";
			echo "<td>".$user["login"];
			echo "</tr>";
		}
	?>
</table>