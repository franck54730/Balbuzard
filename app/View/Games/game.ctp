<!-- File: /app/View/Games/lobby.ctp -->
<style type="text/css">
    .roundedImage{
        border-style:solid dotted;
        border-color:black red;
        overflow:hidden;
        -webkit-border-radius:100px;
        -moz-border-radius:100px;
        border-radius:100px;
        width:250px;
        height:250px;
        background-image: url(1.png);
        
    }
    
    .bidule{
        background: url(2.gif);
    }
    .tab{
      
    margin-left: auto;
    margin-right: auto;
    margin-top: auto;
    margin-bottom: auto;
       
    }

   
</style>


<?php

$var = 57;

while($var){

echo $this->Html->image("cartes/$var.gif"); 
$var--;

}

?>

<div class="roundedImage" >
    
    <table class="tab">
        <tr>
            <td></td>
            <td ><button><?php echo $this->Html->image("cartes/1.gif"); ?></button></td>
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            <td></td>
        </tr>
        <tr>
            
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            
        </tr>
        <tr>
           
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            <td></td>
            <td></td>
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            
        </tr>
        <tr>
            <td></td>
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            <td><?php echo $this->Html->image("cartes/1.gif"); ?></td>
            <td></td>
        </tr>
    </table>
</div>