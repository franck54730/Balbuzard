<!-- File: /app/View/Users/connexion.ctp -->


 
   
  <?php
	  echo $this->Form->create('User', array('action' => 'connexion'));   
	    echo "<table>";
	 
		echo $this->Form->input('login', array( "label" => "Identifiant", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		 
		echo $this->Form->input('password' , array('type' => 'password', "label" => "Mot de passe", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		
		echo $this->Form->submit("Connexion", array('before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		 
		echo"</table>";
   	  echo $this->Form->end();
	?> 
    
     
    <br>
    
    
    <?php
    	echo $this->Html->link("Nouveau Joueur", array('controller' => 'users', 'action' => 'inscription'));
    ?>
