#!/bin/bash

chmod a+rwx -R /var/lib/mysql;
/etc/init.d/mysql start;
printf "Bienvenue dans le docker de l'application Coding Challenge.\n";
printf "N'oubliez pas de lancer la commande : \n";
printf "\t composer update && composer install";
printf "\nAfin d'installer tous les dépendance nécessaires pour l'installation.";
printf "\nSi c'est également la première fois que vous lancez le conteneur, n'oubliez pas de créer une table en base de donnée via la suite de commande suivante :";
printf "\n\tmysql";
printf "\n\tCREATE DATABASE codingchallenge;";
printf "\n\texit";
printf "\n\tphp bin/console doctrine:schema:update -f\n";
printf "Si vous êtes dans un environnement de développement, insérez également les données de test dans votre base à l'aide de la commande :";
printf "\n\t mysql -D < SQL_CREATE.sql";
VBoxManage import ./camisole.ova;
bash;