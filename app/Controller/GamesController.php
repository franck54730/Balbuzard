<?php
class GamesController extends AppController {
	public $helpers = array('Html', 'Form');
	
	public function index() {
		if($this->Session->check("User")){
		}else{
          	$this->Session->setFlash("Vous devez être connecté.");
          		$this->redirect(array('action' => 'connexion','controller' => 'users'));
		}
	}
	
	public function lobby(){
		//TODO mettre les verroux pour les non connectés et ceux qui sont "in game"
		$connect = true;
		if($this->Session->check("User")){
			$all = $this->Game->find('all');
			//print_r($all);
			$games = array();
			foreach($all as $game){
				$game = $game['Game'];
				if($game['status']==Configure::read('STATUS_WAITING'))
					$games[] = $game;
			}
			$this->set(array('games'=>$games));
		}else{
			$connect = false;
		}
		if(!$connect){
          	$this->Session->setFlash("Vous devez être connecté.");
          	$this->redirect(array('controller' => 'users','action' => 'connexion'));
		}
	}	
	
	public function create(){
		if(!empty($this->data)){
			// on insert le new game
			$this->Game->set(array(	"id_creator"=>$this->Session->read("User.id"),
									"nom"=>$this->data['Game']['nom'], 
									"nbJoueurMax"=>$this->data['Game']['nbJoueurMax'],
									"status"=>Configure::read('STATUS_WAITING'),
									"nbJoueur"=>1));
			$this->Game->save();
			$id_game= count($this->Game->find('all'));
			
			$this->loadModel('Lobby');
			$this->Lobby->set(array('id_user'=>$this->Session->read("User.id"),
									'id_game'=>$id_game));
			$this->Lobby->save();
          	$this->redirect(array('action' => 'wait', $id_game));
		}
	}
	
	public function wait($id){
		//TODO mettre les verroux pour les non connectés et ceux qui sont "in game"
		$connect = true;
		if($this->Session->check("User")){
			$this->loadModel('Lobby');
			$this->loadModel('User');
			$users = array();
			$game = $this->Game->findById($id);
			$allLobby = $this->Lobby->find('all');
			
			//sera a vrai si le joueur est deja dans la partie sinon on l'ajoute
			$alreadyPlay = false;
			foreach($allLobby as $lobby){
				$lobby = $lobby['Lobby'];
				if($lobby['id_game'] == $id){
					if($lobby['id_user'] == $this->Session->read("User.id"))
						$alreadyPlay = true;
					$user = $this->User->findById($lobby['id_user']);
					$users[] = $user['User'];
				}
			}
			if(!$alreadyPlay){//alors on l'ajoute a la partie
				$this->Lobby->set(array('id_user'=>$this->Session->read("User.id"),
									'id_game'=>$id));
				$this->Lobby->save();
				$users[] = $this->Session->read("User");
			}
			$this->set(array('users'=>$users, 'game'=>$game['Game']));
		}
		if(!$connect){
          	$this->Session->setFlash("Vous devez être connecté.");
          	$this->redirect(array('controller' => 'users','action' => 'connexion'));
		}
	}
	
	public function game(){
	}
}
