<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
    <head>
	<?php echo $this->Html->charset(); ?>
        <title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
        </title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('mosaic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
    </head>
    <body>
        
        

        
            <div id="header">
            
            	<div id="logo">
					<?php echo $this->Html->link('Balbuzard', array('controller' => 'menus', 'action' => 'regles'));?>
				</div>
				
            	<div id="menu">
            		<?php //echo $this->Html->link('Connexion', array('controller' => 'users','action' => 'index','full_base' => true)); ?>
            		<?php     echo $this->element('menu'); ?>
            		<?php //echo $this->Html->link('Salon', array('controller' => 'games','action' => 'lobby','full_base' => true)); ?>
            	</div>
                
            </div>
            <div id="page" >
            <div class="title">
	            <div id="content">
					<div class="post">
						
						<div class="entry">
            

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
						</div>
					</div>
				</div>
            </div>
            </div>
            <div id="footer">
			<?php //echo $this->Html->link(
					//$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					//'http://www.cakephp.org/',
					//array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				//);
			?>
                <p>
				<?php //echo $cakeVersion; ?>
                </p>
            </div>
        
        
        <div id="sidebar">
        	
        	<li>
        		<h2 class="widgettitle">Réalisé par</h2>
	        	<ul>
					<li >
						<table cellspacing="15">
							<tr>
								<th ><?php echo $this->Html->image('ul.jpeg', array('alt' => 'CakePHP'));?></th>
							</tr>
							<tr >
								<td>Franck</td>
								<td>Valérian</td>
								<td>Ahmed</td>
							</tr>
						</table>    
					</li>
					
					
					
				</ul>
			</li>
        </div>
	<?php //echo $this->element('sql_dump'); ?>
    </body>
</html>
