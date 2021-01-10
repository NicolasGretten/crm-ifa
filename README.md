# Projet CRM par Nicolas Gretten

## .env 
Le fichier .env contient tous les variables d'environnement requises pour l'utilisation de l'application.

Pour la base données j'ai utilisés l'application phpmyadmin est le moteur mariaDB.

Pour la notification des demandes par e-mail j'ai utilisé le serveur smtp de gmail.

Pour comprendre et mettre en place l'envoie d'e-mail avec une adresse gmail personnelle j'ai suivi les guides suivant:

- Mise en place de la variable d'environnement : https://www.hostinger.fr/tutoriels/utiliser-serveur-smtp-gmail/
- Generation d'un mot de passe d'applications si on possède l'identification a deux facteurs sur son compte gmail : https://support.google.com/accounts/answer/185833?hl=fr

L'email du sender est à renseigner pour l'envoie des notifications.

Une fois les variables d'environnement renseigner vous pouvez renommer le fichier .env en .env.locale pour finir la configuration.

## DEV

En environnement de dev on peu utiliser les fixtures pour tester le CRM.
Au load des fixtures, la base de données aura comme données test : 
- 5 entreprises 
- 20 clients qui seront rattachés a une entreprise aléatoire et un client "test" qui n'appartiendra à aucune compagny
- 1 admin avec une adresse e-mail(crm-ifa@yopmail.com) et un mot de passe (0000)
- 1 compte utilisateurs qui est le client "test' : john@doe.com, mot de passe : john.doe
- 1 demande effectuer par le compte utilisateur test

## PROD

En production pour pouvoir se connecter au site il est nécessaire de créer un compte admin, pour cela il est possible d'utiliser la commande suivante :
php bin/console app:create-admin example@gmail.com examplepassword

Une fois cette commande effectuée, vous pourrez vous connecter et utiliser le CRM.

## Fonctionnalités

- Page d'accueil différente pour les Admins et les utilisateurs
- CRUD sur les entreprises, clients, utilisateurs, demandes et tickets
- Création d'un utilisateur en modifiant l'accès à un client (Je transforme le client en utilisateur)
- Création de ticket pour une demande pas obligatoire, un ticket peut être lié à aucune demande
- Les admins peuvent uniquement lister, voir et édité le statut d'une demande
- les users peuvent créer, listés leurs demandes, voir, modifié le contenu de leur demande et supprimer
- Authentification obligatoire pour consulter et naviguer dans le CRM  
- Protection des routes par rôles 
- Listener pour rediriger vers la page d'accueil lorsque qu'une AccessDeniedexception est Throw
- Envoi d'e-mails a la création de la demande sur l'adresse e-mail de l'admin (crm-ifa@yopmail.com) consultable sur Yopmail.com
- Notification des demandes sur la page d'accueil pour l'administrateur, il doit changer leurs status pour pouvoir enlever la notification et informer l'utilisateur que sa demande a été vu par un admin en mettant à jour la colonne Views de No à Yes

## Procédure

- Cloner le projet dans le dossier souhaité.
- composer install
- npm install
- yarn install
- php bin/console doctrine:database:create
- php bin/console doctrine:migrations:migrate
- php bin/console app:create-admin example@gmail.com examplepassword (environnement de production)
- php bin/console doctrine:fixtures:load (environnement de développement)
- yarn encore production (environnement de production)
- yarn encore dev (environnement de développement)
- symfony server:start