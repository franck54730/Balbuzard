<!-- File: /app/View/Users/connexion.ctp -->

<?php
  echo $this->Form->create('User', array('action' => 'connexion'));
  echo $this->Form->input('login');
  echo $this->Form->input('pwd', array('type' => 'password'));
  echo $this->Form->submit("Connexion");
  echo $this->Form->end();
?>
