<!-- File: /app/View/Games/lobby.ctp -->

<h1><?php echo $this->Html->link("Crée une partie", array('controller' => 'games', 'action' => 'create')); ?></h1>

<table>
	<tr>
		<th>Nom de la partie</th>
		<th>Joueurs</th>
	</tr>
	<?php 
		foreach($games as $game){
			echo "<tr>";
			echo "<td>".$game["nom"]."</td>";
			echo "<td>".$game["nbJoueur"]."/".$game["nbJoueurMax"]."</td>";
			echo "</tr>";
		}
	?>
</table>