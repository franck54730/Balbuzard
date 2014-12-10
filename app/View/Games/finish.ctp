<!-- File: /app/View/Games/finish.ctp -->
<h2>Le vainqueur est : <?php echo $winner['User']['login'];?> </h2>
<br>
<?php
    	echo $this->Html->link("Retourner au salon.", array('controller' => 'games', 'action' => 'lobby'));
    ?>