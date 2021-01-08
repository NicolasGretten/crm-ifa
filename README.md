# Projet CRM par Nicolas Gretten

## .env 
Le fichier .env contient tous les variables d'environnement requises pour l'utilisation de l'application.

Pour la base données j'ai utilisés l'application phpmyadmin est le moteur mariaDB.

Pour la notification des demandes par e-mail j'ai utilisé le serveur smtp de gmail.

Pour comprendre et mettre en place l'envoie d'e-mail avec une adresse gmail personnelle j'ai suivi les guides suivant:

- Mise en place de la variable d'environnement : https://www.hostinger.fr/tutoriels/utiliser-serveur-smtp-gmail/
- Generation d'un mot de passe d'applications si on possède l'identification a deux facteurs sur son compte gmail : https://support.google.com/accounts/answer/185833?hl=fr

L'email du sender est à renseigner pour l'envoie des notifications.

##Fixtures

Au load des fixtures, la base de données aura comme données test : 
- 5 entreprises 
- 20 clients qui seront rattachés a une entreprise aléatoire et un client "test" qui n'appartiendra à aucune compagny
- 1 admin avec une adresse e-mail(crm-ifa@yopmail.com) et un mot de passe (0000)
- 1 compte utilisateurs qui est le client "test' : john@doe.com, mot de passe : john.doe
- 1 demande effectuer par le compte utilisateur test

##Fonctionnalités

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