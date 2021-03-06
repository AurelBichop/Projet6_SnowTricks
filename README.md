# projet6_site_communautaire_SnowTricks_OC

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8720c4c852ad40819b24955a89f68229)](https://www.codacy.com/manual/AurelBichop/Projet6_SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AurelBichop/Projet6_SnowTricks&amp;utm_campaign=Badge_Grade)

Bichotte Aurélien

Exemple d'un site communautaire avec une interface d'administration pour supprimer les tricks, supprimer les commentaires ou utlisateurs.
Ce projet a été créé dans l'intérêt de se former au développement en php avec le framework Symfony 4, il fait parti du projet 6 de la formation Développeur d'application - PHP / Symfony d'openclassroom.
https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony


Le projet est actuellement en phase de test.


###Installation de l'application ###

Installer tous les fichiers sur le serveur en utilisant la commande :
 
 __git clone https://github.com/AurelBichop/Projet6_SnowTricks.git__
 
 Faire un import du fichier snowtricks.sql dans sa base de données.
 
 ###Configuration de l'application ###
 
 ##### Base de données et Email ######
 Renseigner la base de données et les informations d'email dans le fichier .env puis dans le fichier /src/Controller/AccountUserController (méthode register et forgotPassword)
 ajouter également votre email et modifier le lien dans body du courriel http://VOTRE_URL/confirm/?token='.$user->getToken()) et http://VOTRE_URL/userpassword/reset/?token='.$user->getToken()

##### ROLE et Variety #####
Renseigner la table variety (le champ 'title') avec les différents noms de catégories que vous souhaitez pour les tricks.

Pour avoir un accés à l'administration, ajouter ROLE_ADMIN dans le champ title de la table role.
Ensuite renseigner la table role_user avec l'id du ROLE_ADMIN (le 1 si vous n'avez pas créé d'autres rôles) et l'id du user que vous souhaitez avoir en administrateur.

##### Interface admin #####

Après avoir définit un ROLE_ADMIN pour un membre, l'interface d'administration est joignable avec http://VOTRE_URL/admin

##Pour un hébergement avec OVH : ##

#### Ajouter un .htaccess dans public/ ####

========================================

RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f

RewriteRule ^(.*)$ index.php [QSA,L]

=======================================


Technologie utilisée :
Symfony 4.3.3, MYSQL v.5.6 ou  MariaDB-10.4.6, langage PHP 7.1
