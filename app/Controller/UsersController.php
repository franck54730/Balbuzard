<?php
class UsersController extends AppController {
	public $helpers = array('Html', 'Form');
	
	public function index() {
		$this->set('users', $this->User->find('all'));
	}
	
	public function connexion() {
		if(!empty($this->data)){
			$connect = false;
			$i = 0;
			$users = $this->User->find('all');
			while(!$connect && $i < count($users)){
				$user = $users[$i];
				$userTab = $user["User"];
				if($userTab['login'] == $this->data['User']['login'] && $userTab['pwd'] == $this->data['User']['pwd'])
					$connect = true;
				$i++;
			}
			if($connect)
          		$this->redirect(array('action' => 'index'));
          	else
          		echo "pas bon";
		}
	}
}
