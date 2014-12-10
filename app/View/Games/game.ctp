<!-- File: /app/View/Games/lobby.ctp -->
<script type="text/javascript">
	(function() {
  		var httpRequest;
  	  	var t=setInterval(makeRequest,500);
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
	    	httpRequest.open('GET', 'http://82.244.102.60/index.php/games/getCartePlateauAjax/'+<?php echo $id_game;?>);
	    	httpRequest.send(null);
	  	}
	
	  	function alertContents() {
	    	if (httpRequest.readyState === 4) {
	      		if (httpRequest.status === 200) {
		      		var table = document.getElementById('table_carte_plateau');
 					var string = httpRequest.responseText;
					var jsonAll = JSON.parse(string);
					var json = jsonAll['carte_plateau'];
					var id_plateau = json['id'];
					var s1 = json['s1'];
					var s2 = json['s2'];
					var s3 = json['s3'];
					var s4 = json['s4'];
					var s5 = json['s5'];
					var s6 = json['s6'];
					var s7 = json['s7'];
					var s8 = json['s8'];

					var innerTable = "<tbody><tr>" + 
					  							"<td></td>" + 
												"<td><img src=\"/app/webroot/img/cartes/"+s1+".gif\" alt=\"\"></td>" +
												"<td><img src=\"/app/webroot/img/cartes/"+s2+".gif\" alt=\"\"></td>" +
									            "<td></td>" +
											"</tr><tr>" +
					  							"<td><img src=\"/app/webroot/img/cartes/"+s3+".gif\" alt=\"\"></td>" + 
												"<td></td>" +
												"<td></td>" +
									            "<td><img src=\"/app/webroot/img/cartes/"+s4+".gif\" alt=\"\"></td>" +
											"</tr><tr>"+
					  							"<td><img src=\"/app/webroot/img/cartes/"+s5+".gif\" alt=\"\"></td>" + 
												"<td></td>" +
												"<td></td>" +
									            "<td><img src=\"/app/webroot/img/cartes/"+s6+".gif\" alt=\"\"></td>" +
											"</tr><tr>"+
					  							"<td></td>" + 
												"<td><img src=\"/app/webroot/img/cartes/"+s7+".gif\" alt=\"\"></td>" +
												"<td><img src=\"/app/webroot/img/cartes/"+s8+".gif\" alt=\"\"></td>" +
									            "<td></td>" +
											"</tr></tbody>";
					table.innerHTML = innerTable;
					
					json = jsonAll['carte_joueur'];
					var id_joueur = json['id'];
					s1 = json['s1'];
					s2 = json['s2'];
					s3 = json['s3'];
					s4 = json['s4'];
					s5 = json['s5'];
					s6 = json['s6'];
					s7 = json['s7'];
					s8 = json['s8'];
					
					innerTable = "<tbody><tr>" + 
							"<td></td>" + 
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s1\"><img src=\"/app/webroot/img/cartes/"+
									s1+".gif\" alt=\"Texte alternatif\" /></a> </td>" +
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s2\"><img src=\"/app/webroot/img/cartes/"+
									s2+".gif\" alt=\"Texte alternatif\" /></a> </td>" +
				            "<td></td>" +
						"</tr><tr>" +
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s3\"><img src=\"/app/webroot/img/cartes/"+
									s3+".gif\" alt=\"Texte alternatif\" /></a></td>" + 
							"<td></td>" +
							"<td></td>" +
				            "<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s4\"><img src=\"/app/webroot/img/cartes/"+
									s4+".gif\" alt=\"Texte alternatif\" /></a></td>" +
						"</tr><tr>"+
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s5\"><img src=\"/app/webroot/img/cartes/"+
									s5+".gif\" alt=\"Texte alternatif\" /></a></td>" + 
							"<td></td>" +
							"<td></td>" +
				            "<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s6\"><img src=\"/app/webroot/img/cartes/"+
									s6+".gif\" alt=\"Texte alternatif\" /></a></td>" +
						"</tr><tr>"+
							"<td></td>" + 
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s7\"><img src=\"/app/webroot/img/cartes/"+
									s7+".gif\" alt=\"Texte alternatif\" /></a></td>" +
							"<td><a href=\"/index.php/Games/clickcard/"+<?php echo $id_game?>+
									"/"+id_plateau+"/"+id_joueur+"/s8\"><img src=\"/app/webroot/img/cartes/"+
									s8+".gif\" alt=\"Texte alternatif\" /></a></td>" +
				            "<td></td>" +
						"</tr></tbody>";

			      	table = document.getElementById('table_carte_joueur');
					table.innerHTML = innerTable;
	      		}
	    	}
	  	}
	})();
</script>

<style type="text/css">
    
    /*
    table {
 border-width:1px; 
 border-style:solid; 
 border-color:black;
 width:50%;
 }
td { 
 border-width:1px;
 border-style:solid; 
 border-color:red;
 width:50%;
 }*/
 
 div.bid { 
margin:0; 
padding:0; 
text-align:center; 
font-size:smaller; // C'est moins important on met en plus petit Oo.
color:  blue;
} 

    .roundedImage{
        border-style:solid dotted;
        border-color: black red ;
        overflow:hidden;
        -webkit-border-radius:100px;
        -moz-border-radius:100px;
        border-radius:100px;
        width:280px;
        height:280px;
        vertical-align: middle

    }

    .tab{

        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
        

    }
    img{
        width: 60px;
        height: 60px;
    }

</style>

<table><tr><td text-align="middle"><div class ="bid">carte plateau</div></td><td><div class="bid">carte joueur</div></td></tr>
    <td>
    
<div class="roundedImage" align="center" id="post">
    <table class="tab" id="table_carte_plateau">
        <tr>
            <td></td>
            <td ><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s1'].".gif",array("style"=>"color: black"))?></td>
            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s2'].".gif"); ?></td>
            <td></td>
        </tr>
        <tr>

            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s3'].".gif"); ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s4'].".gif"); ?></td>

        </tr>
        <tr>

            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s5'].".gif"); ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s6'].".gif"); ?></td>

        </tr>
        <tr>
            <td></td>
            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s7'].".gif"); ?></td>
            <td><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s8'].".gif"); ?></td>
            <td></td>
        </tr>
    </table>
</div>
    </td><td>

<div class="roundedImage" align="center">
    
    <table class="tab" id="table_carte_joueur">
        <tr>
            <td></td>
            <td >
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s1'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s1"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s2'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s2"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
        </tr>
        <tr>

            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s3'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s3"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s4'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s4"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>

        </tr>
        <tr>

            <td>
<?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s5'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s5"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>            </td>
            <td></td>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s6'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s6"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>

        </tr>
        <tr>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s7'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s7"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s8'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_plateau['Card']['id'], $carte_joueur['Card']['id'], "s8"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
        </tr>
    </table>
</div></td>
</table>