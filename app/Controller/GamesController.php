<?php

class GamesController extends AppController {

    public $helpers = array('Html', 'Form');

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
            //print_r($all);
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
                "nbJoueurMax" => $this->data['Game']['nbJoueurMax'],
                "status" => Configure::read('STATUS_WAITING'),
                "nbJoueur" => 0));
            $this->Game->save();
            $id_game = count($this->Game->find('all'));
            //creation du lobby
            $this->loadModel('Lobby');
            $this->Lobby->set(array('id_user' => $this->Session->read("User.id"),
                'id_game' => $id_game));
            $this->Lobby->save();

            include("cards.php");

            $a = cards();
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
            if ($game['Game']['nbJoueur'] + 1 == $game['Game']['nbJoueurMax']) {
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
        //distribuer les cartes (attention bien verifier que ca na pas deja été fait. cette fonction
        //va etre appeler autant de fois qu'il y a de joueur il faut donc tester si le jeu n'a pas 
        //deja distribuer, en verifiant dans la bdd si il y a deja des tuplus existant pour cette 
        //game dans la table deck (il faudra passer par stack))
    }

}
