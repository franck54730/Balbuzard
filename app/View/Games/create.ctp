<!-- File: /app/View/Games/lobby.ctp -->

<?php
  echo $this->Form->create('Game', array('action' => 'create'));
  echo $this->Form->input('nom');
  echo $this->Form->input('nbJoueurMax', array('type' => 'number'));
  echo $this->Form->submit("Créer");
  echo $this->Form->end();
?>