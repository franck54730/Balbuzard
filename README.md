
AISSA Ahmed, AUDIGER Franck, DAMM Valérian

la base de donnée est local et se nomme damm avec en mot de passe damm et user damm (a crée dans la base)
ou modifier le database.php

le script pour crée la base est dans app/sript_db_create.sql
le script pour inseré les utilisateurs et menu dans app/sript_db_insert.sql (script à éxécuter obligatoirement)


pour récupere le projet fini via git :
  git clone https://github.com/franck54730/Balbuzard
puis utiliser la branche "balbuzard_fini"
  git checkout balbuzard_fini
  
si vous voulez modifier l'hôte modifier dans app/Config/core.php la ligne 43 et remplacer 'localhost':
  Configure::write('HOST', 'localhost');
le changement de cette valeur n'influe pas sur la base de données (par defaut 'localhost')