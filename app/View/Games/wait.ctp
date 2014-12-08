<!-- File: /app/View/Games/lobby.ctp -->
<!-- vue d'une partie  -->
<META HTTP-EQUIV="Refresh" CONTENT="1" URL="http://localhost/index.php/games/view/4">

<h2>Partie : <?php echo $game['nom']?></h2>
<?php if($game['id_creator'] == $this->Session->read("User.id")) echo $this->Html->link("Débuter la partie", array('controller' => 'games','action' => 'game', $game['id'] ));?>
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
