# Projet Tct Conseil

### Description

Dépot Github du projet Tct Conseil réalisé dans le cadre d’une évaluation d’entrainement pour Studi.

Dans le dossier Annexes du dépot se trouvent les documents demandés:

- Manuel d’utilisation
- Document technique

---

### Récuperation du projet pour installation en local

Ce projet est réalisé via Symfony 6.0.6

Il est important d’avoir un environnemnt correctement configuré :

https://symfony.com/doc/current/setup.html

- Cloner le dépot :

  git clone https://github.com/Willysmile/ECF_TRT_Conseil.git


- Dupliquer le fichier .env en .env.local

  `cp .env .env.local`


- Adapter le fichier .env.local afin de le rendre compatible avec votre environnement de développement
  (ligne 29 à 31, configuration de la base de donnée)


- Installer les dépendances Javascript

  `npm install`


- Installer les dépendances PHP

  `composer.phar install`


- (Facultatif) Si la base de donnée est configurée mais pas crée

  `php bin/console doctrine:database:create`


- Executer les migrations
  `php bin/console doctrine:migrations:migrate`


- Créer le compte admin (Attention à remplacer l’email et le mot de passe dans la requete suivante)

    Pour Hasher le password à intégrer dans la requete: 
     `symfony console security:hash-password`

  `INSERT INTO admin (id, email, roles, password, firstname, lastname) VALUES (NULL, 'admin@test.fr', '["ROLE_ADMIN"]', '$2y$13$2Q9xkLDArzCRzTx18abBo.FxuZObLDEPfOn9/XdR0N.GMILf57nh2', 'Administrateur', 'Principal');`
  

- Lancer le projet
    `symfony serve`



---

###Deploiement sur Heroku

- Créér un compte sur heroku.com

- Installer la Heroku CLI :

  - Ubuntu : `sudo snap install --classic heroku`

  - Mac Os : `brew tap heroku/brew && brew install heroku`

  - Windows : Télécharger le fichier sur [Heroku.com](https://devcenter.heroku.com/articles/heroku-cli)


- Initialiser votre projet avec Git


- Créér une nouvelle application Heroku
    `heroku create`


- (Facultatif) Modifier le fichier Procfile si votre server n’est pas sous Apache


- Configurer l’environnement de production d’Heroku :

    `heroku config:set APP_ENV=prod`


- Lancer le déploiememnt :

    `git push heroku main`


En cas de soucis de déploiement, retrouvez la procédure de déploiement complète sur [Heroku.com](https://devcenter.heroku.com/articles/deploying-symfony4)