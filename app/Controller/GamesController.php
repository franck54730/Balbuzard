<?php

class GamesController extends AppController {

    var $name = 'Games';
    var $helpers = array('Html');

    public function finish($id_game) {
        $this->loadModel('User');
        $game = $this->Game->findById($id_game);
        $winner = $this->User->findById($game['Game']['id_winner']);
        $this->set(array('game' => $game, 'winner' => $winner));
    }

    public function getCartePlateauAjax($id_game) {
        // no view to render
        $this->autoRender = false;
        $this->response->type('json');
        $carte_plateau = $this->__getCartePlateau($id_game);
        $carte_joueur = $this->__getCarteJoueur($id_game, $this->Session->read('User.id'));
        $json = "{\"carte_plateau\":";
        $json .= "{\"id\":" . $carte_plateau['Card']['id'] . ",";
        $json .= "\"s1\":" . $carte_plateau['Card']['s1'] . ",";
        $json .= "\"s2\":" . $carte_plateau['Card']['s2'] . ",";
        $json .= "\"s3\":" . $carte_plateau['Card']['s3'] . ",";
        $json .= "\"s4\":" . $carte_plateau['Card']['s4'] . ",";
        $json .= "\"s5\":" . $carte_plateau['Card']['s5'] . ",";
        $json .= "\"s6\":" . $carte_plateau['Card']['s6'] . ",";
        $json .= "\"s7\":" . $carte_plateau['Card']['s7'] . ",";
        $json .= "\"s8\":" . $carte_plateau['Card']['s8'];
        $json .= "},";
        $json .= "\"carte_joueur\":";
        $json .= "{\"id\":" . $carte_joueur['Card']['id'] . ",";
        $json .= "\"s1\":" . $carte_joueur['Card']['s1'] . ",";
        $json .= "\"s2\":" . $carte_joueur['Card']['s2'] . ",";
        $json .= "\"s3\":" . $carte_joueur['Card']['s3'] . ",";
        $json .= "\"s4\":" . $carte_joueur['Card']['s4'] . ",";
        $json .= "\"s5\":" . $carte_joueur['Card']['s5'] . ",";
        $json .= "\"s6\":" . $carte_joueur['Card']['s6'] . ",";
        $json .= "\"s7\":" . $carte_joueur['Card']['s7'] . ",";
        $json .= "\"s8\":" . $carte_joueur['Card']['s8'];
        $json .= "}";
        $json .= "}";
        $this->response->body($json);
    }

    public function getPlayerForGame($id_game) {
        $game = $this->Game->findById($id_game);
        $json = "{\"redirect\":1}";
        if ($game['Game']["status"] == Configure::read('STATUS_DEAL')) {
            $json = "{\"redirect\":1}";
        } else {
            $json = "{\"joueurs\":[";
            // no view to render
            $this->autoRender = false;
            $this->response->type('json');
            $this->loadModel('User');
            $game = $this->Game->findById($id_game);
            $nbPlayer = $game['Game']['nbJoueur'];
            $this->loadModel('Lobby');
            $allLobby = $this->Lobby->find('all');
            $i = 0;
            foreach ($allLobby as $lobby) {
                $lobby = $lobby['Lobby'];
                if ($lobby['id_game'] == $id_game) {
                    $user = $this->User->findById($lobby['id_user']);
                    $json .= "{\"login\":\"" . $user['User']['login'] . "\"}";
                    $i++;
                    if ($i < $nbPlayer) {
                        $json .= ",";
                    }
                }
            }
            $json .= "]}";
        }
        $this->response->body($json);
    }

    public function clickCard($id_game, $id_card_plateau, $id_card_joueur, $num_symbole) {
        $this->loadModel('Card');
        $carte_plateau = $this->Card->findById($id_card_plateau);
        $carte_joueur = $this->Card->findById($id_card_joueur);
        echo "id card plateau : " . $id_card_plateau . "<br>";
        echo "id card joueur : " . $id_card_joueur . "<br>";
        $good = false;
        $i = 0;
        while (!$good && $i < 8) {
            $symbole = 's' . ($i + 1);
            echo $carte_joueur['Card'][$num_symbole] . " == " . $carte_plateau['Card'][$symbole] . "<br>";
            if ($carte_joueur['Card'][$num_symbole] == $carte_plateau['Card'][$symbole]) {
                $good = true;
            } else {
                $i++;
            }
        }
        echo $good;

        if ($good) {
            $this->loadModel('Stack');
            $this->loadModel('Card');
            $this->loadModel('Deck');

            //on change l'ordre de la carte dans le stack qui vient au dessus si c'est bon
            $stacks = $this->Stack->find('all');
            $j = 0;
            $stack;
            $ordre;
            $trouv = false;
            while (!$trouv && $j < count($stacks)) {
                $stack = $stacks[$j];
                if ($stack['Stack']['id_card'] == $id_card_joueur) {
                    $trouv = true;
                } else {
                    $j++;
                }
            }
            $id_stack = $stack['Stack']['id'];
            $newOrdre = $this->__getOrdreMaxStack($id_game) + 1;
            $this->Stack->clear();
            $this->Stack->id = $id_stack;
            $this->Stack->saveField("ordre", $newOrdre);
            $this->Stack->clear();
            //on change l'ordre de la carte dans le deck qui part et va dans le stack
            $decks = $this->Deck->find('all');
            $j = 0;
            $deck;
            $trouv = false;
            while (!$trouv && $j < count($stacks)) {
                $deck = $decks[$j];
                if ($deck['Deck']['id_card'] == $id_card_joueur && $deck['Deck']['id_user'] == $this->Session->read('User.id')) {
                    $trouv = true;
                } else {
                    $j++;
                }
            }
            $id_deck = $deck['Deck']['id'];
            $this->Deck->clear();
            $this->Deck->id = $id_deck;
            $this->Deck->saveField("ordre", -1);
            $this->Deck->clear();
        }
        $this->redirect(array('controller' => 'games', 'action' => 'game', $id_game));
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
                "nbJoueurMax" => $this->data['Game']['nbJoueurMax'] == "" ? 4 : $this->data['Game']['nbJoueurMax'],
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
            if ($game['Game']["status"] == Configure::read('STATUS_DEAL')) {
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
        $j = 0;
        $trouv = false;
        while (!$trouv && $j < count($games)) {

            $game = $games[$j];
            if ($game['Game']['id'] == $id_game) {
                $trouv = true;
            } else {
                $j++;
            }
        }
        if ($game['Game']['status'] == Configure::read('STATUS_FINISH')) {
            $this->redirect(array('controller' => 'games', 'action' => 'finish', $id_game));
        }
        if ($game['Game']['status'] == Configure::read('STATUS_WAITING')) {
            $this->Game->id = $game['Game']['id'];
            $this->Game->saveField("status", Configure::read('STATUS_PLAY'));
        }
        $games = $this->Game->find('all', array('condition' => array("Game.id" => $id_game)));
        $j = 0;
        $trouv = false;
        while (!$trouv && $j < count($games)) {

            $game = $games[$j];
            if ($game['Game']['id'] == $id_game) {
                $trouv = true;
            } else {
                $j++;
            }
        }
        //si les cartes nes sont pas deja distribué
        if ($game['Game']['status'] == Configure::read('STATUS_PLAY')) {
            $stacks = $this->Stack->find('all');
            $nbjoueur = $game['Game']['nbJoueur'];
            //on recupere les joueurs de la partie
            $tabIdJoueur = $this->__tabIdPlayer($id_game);
            $tabOrdreJoueur = array();
            foreach ($tabIdJoueur as $j) {
                $tabOrdreJoueur[] = 1;
            }
            $i = 0;
            //pour chaque carte du stack on l'enleve du stack et on la met dans un deck
            foreach ($stacks as $stack) {
                if ($stack['Stack']['id_game'] == $id_game) {
                    $ordre = $stack['Stack']['ordre'];
                    //si ce n'est pas la derniere carte on la distribue
                    if ($ordre != 1) {
                        $this->__saveDeck($tabIdJoueur[$i], $id_game, $tabOrdreJoueur[$i], $stack['Stack']['id_card']);
                        $tabOrdreJoueur[$i] += 1;
                        $this->Stack->id = $stack['Stack']['id'];
                        $this->Stack->saveField("ordre", -1);
                        $i++;
                        if ($i >= $nbjoueur) {
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
        if ($Cjoueur == null) {
            $this->Game->id = $id_game;
            $this->Game->saveField("status", Configure::read('STATUS_FINISH'));
            $this->Game->saveField("id_winner", $this->Session->read('User.id'));
            $this->redirect(array('controller' => 'games', 'action' => 'finish', $id_game));
        }
        $this->set(array(
            'carte_joueur' => $Cjoueur,
            'carte_plateau' => $Cplateau,
            'id_game' => $id_game
        ));
    }

    public function __cards() {

        function c($i, $j) {
            return $i + 7 * $j + 9;
        }

        $A = array();
        $B = array();
        $C = array();
        for ($i = 0; $i < 8; $i++) {
            $A[0][] = 1 + $i;
        }
        for ($i = 0; $i < 7; $i++) {
            $B[$i][] = 1;
            for ($j = 0; $j < 7; $j++) {
                $B[$i][] = c($i, $j);
            }
        }
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $C[$i + 7 * $j][] = $i + 2;
                for ($k = 0; $k < 7; $k++) {
                    $C[$i + 7 * $j][] = c($k, ($k * $i + $j) % 7);
                }
            }
        }
        return array_merge($A, $B, $C);
    }

    public function __createCard($id_game) {
        $a = $this->__cards();
        $ordre = 1;//creation des cartes
        
        shuffle($a);
        foreach ($a as $c) {
            //creation d'une carte
            $this->loadModel('Card');
            $deal = array(1, 2, 3, 4, 5, 6, 7, 8);
            shuffle($deal);
            $symbole = 0;
            //ajout des symboles a la carte
            foreach ($c as $d) {
                $this->Card->set(array("s$deal[$symbole]" => $d));
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
        foreach ($joueurs as $joueur) {
            if ($joueur["Lobby"]['id_game'] == $id_game)
                $tabId[] = $joueur["Lobby"]['id_user'];
        }
        return $tabId;
    }

    public function __saveDeck($id_user, $id_game, $ordre, $id_card) {
        $this->loadModel("Deck");
        $this->Deck->clear();
        $this->Deck->set(array('id_user' => $id_user, 'id_game' => $id_game, 'ordre' => $ordre, 'id_card' => $id_card));
        $this->Deck->save();
        $this->Deck->clear();
    }

    public function __updateOrdreDeck($id_deck, $ordre) {
        $this->loadModel("Deck");
        $this->Deck->clear();
        $this->Deck->id = $id_deck;
        $this->Deck->saveField("ordre", $ordre);
        $this->Deck->clear();
    }

    public function __getCarteJoueur($id_game, $id_joueur) {
        $this->loadModel('Deck');
        $this->loadModel('Card');
        $all = $this->Deck->find('all');
        $rep = null;
        $ordre = 0;
        foreach ($all as $deck) {
            if ($deck['Deck']['id_game'] == $id_game && $deck['Deck']['id_user'] == $id_joueur) {
                if ($ordre < $deck['Deck']['ordre']) {
                    $ordre = $deck['Deck']['ordre'];
                    $rep = $deck['Deck']['id_card'];
                }
            }
        }
        return $this->Card->findById($rep);
    }

    public function __getCartePlateau($id_game) {
        $this->loadModel('Stack');
        $this->loadModel('Card');
        $all = $this->Stack->find('all');
        $rep = array();
        $ordre = 0;
        foreach ($all as $stack) {
            if ($stack['Stack']['id_game'] == $id_game) {
                if ($ordre < $stack['Stack']['ordre']) {
                    $ordre = $stack['Stack']['ordre'];
                    $rep = $stack;
                }
            }
        }
        return $this->Card->findById($rep['Stack']['id_card']);
    }

    public function __getOrdreMaxStack($id_game) {
        $rep = 0;
        $ordre = 0;
        $this->loadModel('Stack');
        $all = $this->Stack->find('all');
        foreach ($all as $stack) {
            if ($stack['Stack']['id_game'] == $id_game) {
                if ($ordre < $stack['Stack']['ordre']) {
                    $rep = $stack['Stack']['ordre'];
                    $ordre = $stack['Stack']['ordre'];
                }
            }
        }
        return $rep;
    }

    public function __getOrdreMaxDeck($id_game, $id_user) {
        $rep = 0;
        $ordre = 0;
        $this->loadModel('Stack');
        $all = $this->Stack->find('all');
        foreach ($all as $stack) {
            if ($stack['Stack']['id_game'] == $id_game) {
                if ($ordre < $stack['Stack']['ordre']) {
                    $rep = $stack['Stack']['ordre'];
                    $ordre = $stack['Stack']['ordre'];
                }
            }
        }
        return $rep;
    }

}
