# projet6_site_communautaire_SnowTricks_OC

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/8720c4c852ad40819b24955a89f68229)](https://www.codacy.com/manual/AurelBichop/Projet6_SnowTricks?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=AurelBichop/Projet6_SnowTricks&amp;utm_campaign=Badge_Grade)

Bichotte Aurelien

Exemple d'un site communautaire avec une interface d'administration pour supprimer les tricks, supprimer les commentaires ou utlisateurs.
Ce projet à été crée dans l'interet de se former au dévellopement en php avec le framework Symfony 4, il fait parti du projet 6 de la formation Développeur d'application - PHP / Symfony d'openclassroom.
https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony


le projet est actuelement en phase de test.


Pour un hebergement avec OVH : 
ajouter 2 .htaccess

Un dans la racine de ton projet
================================
SetEnv SHORT_OPEN_TAGS 0
SetEnv REGISTER_GLOBALS 0
SetEnv MAGIC_QUOTES 0
SetEnv SESSION_AUTOSTART 0
SetEnv ZEND_OPTIMIZER 1
SetEnv PHP_VER 7_2

RewriteEngine on
RewriteBase /

RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L]
====================================

Et un autre dans public/
==================================
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ index.php [QSA,L]
=======================================


Technologie utilisé :
Base de donnée : Sypfony 4.3.3, MYSQL ou MariaDB, langage PHP 7.1.
