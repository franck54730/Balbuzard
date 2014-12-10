<?php
class MenusController extends AppController {
	var $name = 'Menus';

	function index() {
		if (isset($this->params['requested']) && $this->params['requested'] == true) {
			$menus = $this->Menu->find('all');
			return $menus;
		} else {
			$this->set('menus', $this->Menu->find('all'));
		}
	}
	
	function regles() {
		
	}
}
?>