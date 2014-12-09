<!-- File: /app/View/Games/lobby.ctp -->
<style type="text/css">
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


<?php
//$this->fetch('content');
$var = 57;

echo $carte_joueur['Card']['id'];
echo $carte_plateau['Card']['s1'];



?>



<p>carte du plateau</p>
<div class="roundedImage" align="center" id="post">
    
    <table class="tab" >
        <tr>
            <td></td>
            <td ><?php echo $this->Html->image("cartes/".$carte_plateau['Card']['s1'].".gif")?></td>
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

<p align="center">carte du joueur</p>
<div class="roundedImage" align="center">
    
    <table class="tab" align="center">
        <tr>
            <td></td>
            <td >
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s1'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s1"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s2'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s2"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
        </tr>
        <tr>

            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s3'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s3"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s4'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s4"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>

        </tr>
        <tr>

            <td>
<?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s5'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s5"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>            </td>
            <td></td>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s6'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s6"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>

        </tr>
        <tr>
            <td></td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s7'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s7"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td>
                <?php echo $this->Html->link(
          $this->Html->image("cartes/".$carte_joueur['Card']['s8'].".gif", array('alt' => "Texte alternatif")), // Recherche dans le dossier webroot/img
          array('controller' => 'Games',  'action' => 'clickcard',  $id_game, $carte_joueur['Card']['id'], "s8"),
          array('escape' => false) // Ceci pour indiquer de ne pas échapper les caractères HTML du lien vu qu'ici tu as une image
     );?>
            </td>
            <td></td>
        </tr>
    </table>
</div>