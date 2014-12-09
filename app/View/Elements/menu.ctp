   
    
    <?php 
    if($this->Session->check("User")){
			foreach($menus as $menu): 
         		if($menu['Menu']['action'] != "connexion"){
          			echo $this->Html->link($menu['Menu']['name'], array('controller' => $menu['Menu']['controller'],'action' => $menu['Menu']['action'],'full_base' => true));
         		}
   			endforeach;
		}else{
			
			
          	foreach($menus as $menu): 
         		if($menu['Menu']['action'] != "deconnexion"){
          			echo $this->Html->link($menu['Menu']['name'], array('controller' => $menu['Menu']['controller'],'action' => $menu['Menu']['action'],'full_base' => true));
         		}
   			endforeach; 
	   		
		}
		
	?>