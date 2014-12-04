<?php
class UsersController extends AppController {
	public $helpers = array('Html', 'Form');
	
	public function index() {
		if($this->Session->check("User")){
			$this->set('users', $this->User->find('all'));
		}else{
          	$this->Session->setFlash("Vous devez être connecté.");
          		$this->redirect(array('action' => 'connexion'));
		}
	}
	
	public function connexion() {
		if(!empty($this->data)){
			$connect = false;
			$i = 0;
			$users = $this->User->find('all');
			while(!$connect && $i < count($users)){
				$user = $users[$i];
				$userTab = $user["User"];
				if($userTab['login'] == $this->data['User']['login'] && $userTab['pwd'] == $this->data['User']['pwd']){
					$thisUser = $this->User->findById($userTab['id']);
					$this->Session->write("User",$thisUser["User"]);
					$connect = true;
				}
				$i++;
			}
			if($connect){
          		$this->redirect(array('controller' => 'games','action' => 'lobby'));
			}else{
          		$this->Session->setFlash("Votre connexion a échouée.");
			}
		}
	}
}
