<!-- File: /app/View/Games/lobby.ctp -->

			
			<h2>Nouvelle partie : </h2>
<?php
  echo $this->Form->create('Game', array('action' => 'create'));

  	echo "<table>";
	 
		echo $this->Form->input('nom', array( "label" => "Nom de la partie", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false)); 
		echo $this->Form->input('nbJoueurMax' , array('type' => 'number', "label" => "Nombre de joueur maximum", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		echo $this->Form->submit("Créer", array('before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		 
	echo"</table>";
  
  echo $this->Form->end();
  
?>
