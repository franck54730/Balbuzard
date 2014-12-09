<!-- File: /app/View/Users/inscription.ctp -->

    
<?php
  echo $this->Form->create('User', array('action' => 'inscription'));
 
  
	echo "<table>";
	 
		echo $this->Form->input('login', array( "label" => "Identifiant", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false)); 
		echo $this->Form->input('password' , array('type' => 'password', "label" => "Mot de passe", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		echo $this->Form->input('password_r' , array('type' => 'password', "label" => "confirmer mot de passe", 'before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		echo $this->Form->submit("Inscription", array('before' => '<tr><td>', 'after' => '</td></tr>', 'between' =>'</td><td>', 'div' => false));
		 
	echo"</table>";
  

    
 echo $this->Form->end();
?> 