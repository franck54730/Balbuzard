<!-- File: /app/View/Games/lobby.ctp -->
<!-- vue d'une partie  -->
<!-- <META HTTP-EQUIV="Refresh" CONTENT="1" URL="http://localhost/index.php/games/view/4"> -->
<script type="text/javascript">
	(function() {
  		var httpRequest;
  	  	var t=setInterval(makeRequest,1000);
	  	function makeRequest() {
	    	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
	      		httpRequest = new XMLHttpRequest();
	    	} else if (window.ActiveXObject) { // IE
	      		try {
	        		httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
	      		} 
	      		catch (e) {
	        		try {
	          			httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
	        		} 
	        		catch (e) {}
	      		}
	    	}
	
	    	if (!httpRequest) {
	      		alert('Giving up :( Cannot create an XMLHTTP instance');
	      		return false;
	    	}
	    	httpRequest.onreadystatechange = alertContents;
	    	httpRequest.open('GET', 'http://82.244.102.60/index.php/games/getPlayerForGame/'+<?php echo $game['id'];?>);
	    	httpRequest.send();
	  	}
	
	  	function alertContents() {
	    	if (httpRequest.readyState === 4) {
	      		if (httpRequest.status === 200) {
 					var string = httpRequest.responseText;
 				
 					if(string != ""){
 			      		var table = document.getElementById('table_joueur');
 			      		var innerTable = "<tbody><tr><th>Joueurs</th></tr>";
 	 					var json = JSON.parse(string);

						var redirect = json['redirect'];
						var joueurs = json['joueurs'];
		        		for(var i = 0; i < joueurs.length; i++) {
			        		var joueur = joueurs[i];
							var string2 = JSON.stringify(joueur);
							var login = joueur['login']
							innerTable += "<tr><td>"+login+"</td></tr>";
					    }
					    innerTable += "</tbody>";
					    table.innerHTML = innerTable;
 	 				}else{	
 	 	 				window.location.href = 'http://82.244.102.60/index.php/games/game/'+<?php echo $game['id'];?>;
 	 	 			}
					
	      		}else
	 				window.location.href = 'http://82.244.102.60/index.php/games/wait/'+<?php echo $game['id'];?>;
	    	}
	  	}
	})();
</script>
<p id='test'></p>
<h2>Partie : <?php echo $game['nom']?></h2>
<?php if($game['id_creator'] == $this->Session->read("User.id")) echo $this->Html->link("Débuter la partie", array('controller' => 'games','action' => 'game', $game['id'] ));?>
<table id="table_joueur">
	<tr>
		<th>Joueurs</th>
	</tr>
	<?php 
		foreach($users as $user){
			echo "<tr>";
			echo "<td>".$user["login"];
			echo "</tr>";
		}
	?>
</table>
