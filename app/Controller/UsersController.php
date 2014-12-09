<?php
class UsersController extends AppController {
	var $components = array('Security');
	
	
	public $helpers = array('Html', 'Form');
	
	public function index() {
		if($this->Session->check("User")){
			$this->redirect(array('controller' => 'games','action' => 'lobby'));
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
				if($userTab['login'] == $this->data['User']['login'] && $userTab['pwd'] == $this->data['User']['password']){
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
	
	public function deconnexion(){
		$this->Session->destroy();
		$this->redirect(array('controller' => 'users','action' => 'connexion'));
	}
	
	public function inscription(){
		
		if(!empty($this->data))
		{
			$existe=false;
			$i = 0;
			$users = $this->User->find('all');
			while( $i < count($users)){
				$user = $users[$i];
				$userTab = $user["User"];
				if($userTab['login'] == $this->data['User']['login'] && !$existe){
					$this->Session->setFlash("Cet identifiant existe deja.");
					$this->redirect(array('controller' => 'users','action' => 'inscription'));
					$existe=true;
				}
				$i++;
			}
			if(!$existe){
				$this->User->set( $this->data );
					
					
				
				if( $this->User->validates() )
				{
					$connect = false;
					// on insert le new user
					$this->User->set(array(
							"login" => $this->data['User']['login'],
							"pwd" => $this->data['User']['password']));
					$this->User->save($this->data);
				
					/*$id_user = count($this->User->find('all'));*/
						
					$connect = true;
					if($connect){
						$this->redirect(array('controller' => 'games','action' => 'lobby'));
					}else{
						$this->Session->setFlash("Votre connexion a échouée.");
					}
				
				
				}else
				{
					$this->validateErrors($this->User);
				}
			}
			
		}
		
	}
}
