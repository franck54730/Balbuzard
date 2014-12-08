<?php

class GamesController extends AppController {
    var $name = 'Games';
    var $helpers = array('Html','Ajax','Javascript');
    var $components = array( 'RequestHandler' );

    public function clickCard($id_game, $id_card, $num_symbole){
    	$carte_plateau = $this->__getCartePlateau($id_game);
    	$carte_joueur = $this->__getCarteJoueur($id_game,$this->Session->read('User.id'));
    	echo $num_symbole."<br>";
        echo '$carte_plateau : '; print_r($carte_plateau);
        echo "<br>";
        echo '$carte_joueur : '; print_r($carte_joueur);
        echo "<br>";
    	$good = false;
    	$i=0;
    	while(!$good && $i < 8){
    		echo $carte_joueur['Card'][$num_symbole]." == ".$carte_plateau['Card'][$i]."<br>";
    		$symbole = 's'.($i+1);
    		echo "sybole : ".$symbole."<br>";
    		if($carte_joueur['Card'][$num_symbole] == $carte_plateau['Card'][$symbole]){
    			$good = true;
    		}else{
    			$i++;
    		}
    	}
    	if($good){echo "good : true<br>";}else{echo "good : false<br>";}
    	
    }
    
    public function index() {
        if ($this->Session->check("User")) {
            
        } else {
            $this->Session->setFlash("Vous devez être connecté.");
            $this->redirect(array('action' => 'connexion', 'controller' => 'users'));
        }
    }

    public function lobby() {
        //TODO mettre les verroux pour les non connectés et ceux qui sont "in game"
        $connect = true;
        if ($this->Session->check("User")) {
            $all = $this->Game->find('all');
            $games = array();
            foreach ($all as $game) {
                $game = $game['Game'];
                if ($game['status'] == Configure::read('STATUS_WAITING') && $game['nbJoueur'] < $game['nbJoueurMax'])
                    $games[] = $game;
            }
            $this->set(array('games' => $games));
        }else {
            $connect = false;
        }
        if (!$connect) {
            $this->Session->setFlash("Vous devez être connecté.");
            $this->redirect(array('controller' => 'users', 'action' => 'connexion'));
        }
    }

    public function create() {
        if (!empty($this->data)) {
            // on insert le new game
            $this->Game->set(array("id_creator" => $this->Session->read("User.id"),
                "nom" => $this->data['Game']['nom'],
                "nbJoueurMax" => $this->data['Game']['nbJoueurMax']==""?4:$this->data['Game']['nbJoueurMax'],
                "status" => Configure::read('STATUS_WAITING'),
                "nbJoueur" => 1));
            $this->Game->save();
            $id_game = count($this->Game->find('all'));
            //creation du lobby
            $this->loadModel('Lobby');
            $this->Lobby->set(array('id_user' => $this->Session->read("User.id"),
                'id_game' => $id_game));
            $this->Lobby->save();
            $this->__createCard($id_game);
            $this->redirect(array('action' => 'wait', $id_game));
        }
    }

    public function wait($id) {
        //TODO mettre les verroux pour les non connectés et ceux qui sont "in game"
        $connect = true;
        if ($this->Session->check("User")) {
            $this->loadModel('Lobby');
            $this->loadModel('User');
            $users = array();
            $game = $this->Game->findById($id);
            //si la partie est commencer on commence a jouer
            if ($game['Game']["status"] == Configure::read('STATUS_PLAY')) {
                $this->redirect(array('controller' => 'games', 'action' => 'game', $id));
            }
            $allLobby = $this->Lobby->find('all');

            //sera a vrai si le joueur est deja dans la partie sinon on l'ajoute
            $alreadyPlay = false;
            foreach ($allLobby as $lobby) {
                $lobby = $lobby['Lobby'];
                if ($lobby['id_game'] == $id) {
                    if ($lobby['id_user'] == $this->Session->read("User.id"))
                        $alreadyPlay = true;
                    $user = $this->User->findById($lobby['id_user']);
                    $users[] = $user['User'];
                }
            }
            $this->Game->id = $id;
            //si il ya le nombre max de joueur la partie commence
            if ($game['Game']['nbJoueur'] == $game['Game']['nbJoueurMax']) {
                $this->Game->saveField("status", Configure::read('STATUS_PLAY'));
            }
            if (!$alreadyPlay) {//alors on l'ajoute a la partie
                $this->Lobby->set(array('id_user' => $this->Session->read("User.id"),
                    'id_game' => $id));
                $this->Lobby->save();
                $this->Game->saveField("nbJoueur", $game['Game']['nbJoueur'] + 1);
                $users[] = $this->Session->read("User");
            }
            $this->set(array('users' => $users, 'game' => $game['Game']));
        }
        if (!$connect) {
            $this->Session->setFlash("Vous devez être connecté.");
            $this->redirect(array('controller' => 'users', 'action' => 'connexion'));
        }
    }

    public function game($id_game) {
        $this->loadModel("Game");
        $this->loadModel("Stack");
        $games = $this->Game->find('all', array('condition' => array("Game.id" => $id_game)));
        $j=0;
        $trouv = false;
        while(!$trouv && $j < count($games)){
        	
        	$game=$games[$j];
        	if($game['Game']['id'] == $id_game){
        		$trouv = true;
        	}else{
        		$j++;
        	}
        }
        if($game['Game']['status'] == Configure::read('STATUS_WAITING')){
        	$this->Game->id = $game['Game']['id'];
        	$this->Game->saveField("status", Configure::read('STATUS_PLAY'));
        }
      	$games = $this->Game->find('all', array('condition' => array("Game.id" => $id_game)));
        $j=0;
        $trouv = false;
        while(!$trouv && $j < count($games)){
        	
        	$game=$games[$j];
        	if($game['Game']['id'] == $id_game){
        		$trouv = true;
        	}else{
        		$j++;
        	}
        }
        //si les cartes nes sont pas deja distribué
        if($game['Game']['status'] == Configure::read('STATUS_PLAY')){
	        $stacks = $this->Stack->find('all');
	        $nbjoueur = $game['Game']['nbJoueur'];
	        //on recupere les joueurs de la partie
	        $tabIdJoueur = $this->__tabIdPlayer($id_game);
	        $tabOrdreJoueur = array();
	        foreach($tabIdJoueur as $j){
	        	$tabOrdreJoueur[] = 1;
	        }
	        $i = 0;
	        //pour chaque carte du stack on l'enleve du stack et on la met dans un deck
	        foreach($stacks as $stack){
	        	if($stack['Stack']['id_game']== $id_game){
	        		$ordre = $stack['Stack']['ordre'];
	        		//si ce n'est pas la derniere carte on la distribue
	        		if($ordre != 1){
	        			$this->__saveDeck($tabIdJoueur[$i], $stack['Stack']['id'], $tabOrdreJoueur[$i]);
	        			$tabOrdreJoueur[$i] += 1;
	        			$this->Stack->id = $stack['Stack']['id'];
                		$this->Stack->saveField("ordre", -1);
	        			$i++;
	        			if($i >= $nbjoueur){
	        				$i = 0;
	        			}
	        		}
	        	}
	        }
	        //on informe la base que la partie est distribué
	        $this->Game->id = $id_game;
            $this->Game->saveField("status", Configure::read('STATUS_DEAL'));
        }
        //on recupere $carte_joueur et $carte_plateau
        $Cplateau = $this->__getCartePlateau($id_game);
        $Cjoueur = $this->__getCarteJoueur($id_game, $this->Session->read("User.id"));
        $this->set(array(
        				'carte_joueur' => $Cjoueur,
        				'carte_plateau' => $Cplateau,
        				'id_game' => $id_game
        			));
    }
    
    public function __cards() {
        function c($i, $j) {
            return $i + 7*$j + 9;  
        }
        $A = array();
        $B = array();
        $C = array();
        for ($i=0; $i<8; $i++) {
            $A[0][] = 1 + $i;
        }
        for ($i=0; $i<7; $i++) {
            $B[$i][] = 1;
            for ($j=0; $j<7; $j++) {
                $B[$i][] = c($i, $j);
            }
        }
        for ($i=0; $i<7; $i++) {
            for ($j=0; $j<7; $j++) {
                $C[$i+7*$j][] = $i+2; 
                for ($k=0; $k<7; $k++) {
                   $C[$i+7*$j][] = c($k, ($k*$i+$j)%7);
                }
            }
        }
        return array_merge($A, $B, $C);
    }    

	public function __createCard($id_game){
            $a = $this->__cards();
            $ordre = 1;

            //creation des cartes
            foreach ($a as $c) {
                //creation d'une carte
                $this->loadModel('Card');
                $symbole = 1;
                //ajout des symboles a la carte
                foreach ($c as $d) {
                    $this->Card->set(array("s$symbole" => $d));
                    $symbole++;
                }
                $id_card = count($this->Card->find('all'));
                //sauvegarde de la carte               
                $this->Card->save();
                //clear pour creation de la carte suivante
                $this->Card->clear();
                //creation du stack de la carte
                $this->loadModel('Stack');
                // ordre = id de la carte quand la carte n'est pas distribuée
                $this->Stack->set(array('id_game' => $id_game, 'id_card' => $id_card + 1, 'ordre' => $ordre));
                $this->Stack->save();
                $this->Stack->clear();
                $ordre++;
            }
            //fin creation des cartes
	}
    
     public function __tabIdPlayer($id_game) {
       	$tabId = array();
       	$this->loadModel("Lobby");
       	$joueurs = $this->Lobby->find('all');
       	foreach($joueurs as $joueur){
       		if($joueur["Lobby"]['id_game'] == $id_game)
       			$tabId[] = $joueur["Lobby"]['id_user'];
       	}
        return $tabId;
    }  
    
    public function __saveDeck($id_user, $id_stack, $ordre){
        $this->loadModel("Deck");
        $this->Deck->set(array('id_user' => $id_user, 'id_stack' => $id_stack, 'ordre' => $ordre));
        $this->Deck->save();
        $this->Deck->clear();
    }
    
    public function __getCarteJoueur($id_game, $id_joueur){
        $this->loadModel('Deck');
    	$this->loadModel('Card');
    	$this->loadModel('Stack');
    	$all = $this->Deck->find('all');
    	$rep = array();
    	$ordre = 0;
    	foreach($all as $deck){
    		$stack = $this->Stack->findById($deck['Deck']['id_stack']);
    		if($stack['Stack']['id_game'] == $id_game && $deck['Deck']['id_user'] == $id_joueur){
    			if($ordre<$deck['Deck']['ordre'])
    				$rep = $stack;
    		}
    	}
    	return $this->Card->findById($rep['Stack']['id_card']);
    }

    public function __getCartePlateau($id_game){
    	$this->loadModel('Stack');
    	$this->loadModel('Card');
    	$all = $this->Stack->find('all');
    	$rep = array();
    	$ordre = 0;
    	foreach($all as $stack){
    		if($stack['Stack']['id_game'] == $id_game){
    			if($ordre<$stack['Stack']['ordre'])
    				$rep = $stack;
    		}
    	}
    	return $this->Card->findById($rep['Stack']['id_card']);
    }
}
