# Projet CRM par Nicolas Gretten
## .env 
le fichier .env contient tous les variables d'environnement requises pour l'utilisation de l'application.

Pour la base données j'ai utilisés l'application phpmyadmin est le moteur mariaDB.

Pour la notification des demandes par e-mail j'ai utiliser le serveur smtp de gmail.

Pour comprendre et mettre en place l'envoie d'e-mail avec une adresse gmail personnelle j'ai suivi les guides suivant:

- Mise en place de la variable d'environnement : https://www.hostinger.fr/tutoriels/utiliser-serveur-smtp-gmail/
- Géneration d'un mot de passe d'applications si on possède l'identification a deux facteurs sur son compte gmail : https://support.google.com/accounts/answer/185833?hl=fr

L'email du sender est a renseigner pour l'envoie des notification.

##Structure de l'application

##Fixtures

5 Fixtures :
- Company
- Customer
- Demand
- User
- Ticket

Au load des fixtures, seront créer : 5 company, 20 customer qui seront rattaché a une compagny aléatoire, un admin avec une adresse e-mail(crm-ifa@yopmail.com) et un mot de passe (0000), 

##Fonctionnalités
- Protection des routes par roles 
- Listener pour rediriger vers la home page lorsque qu'une AccessDeniedexception est Throw