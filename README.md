# prepaTIsymdocker

## Repository de consignes

Ce repository contient les consignes pour le **TI** de  l'installation de `Symfony LTS` avec `Docker`.

La partie `Docker` vous sera donnée par Magib.

## Gardez ce répertoire ouvert dans un onglet de votre navigateur

## Site de référence

Voici le lien vers la version minimale demandée pour ce **TI** : [sym64simple.cf2m.be](https://sym64simple.cf2m.be/)

## Objectifs Symfony

Vous devez créer un site avec un template `Twig` responsive avec au minimum :

**Front End**
- Un `menu` sur toutes les pages Front End avec `retour à l'accueil`, les `sections cliquables` (via le `slug` !), et le bouton `Connexion` (ou `Déconnexion` ainsi que `Administration` si connecté !)
- Une `page d'accueil`, avec les `10 derniers articles publiés`, avec l'affichage du `titre`, de l'`auteur`, de la `date de publication`, des `sections clickables` (s'il y en a), les **300** premiers caractères du `texte` de l'article (non coupés !), et un bouton `Lire la suite` qui utilise le `slug` de l'article pour afficher l'article complet.

- Une page par `section`, via son `slug`, affiche le `titre de la section` et le `détail` (s'il y en a un), puis `TOUS les articles de cette section`, avec l'affichage du `titre`, des `sections clickables` s'il y en a, de l'`auteur`, de la `date de publication` et **200** premiers caractères du `texte` de l'article (non coupés !), et un bouton `Lire la suite` qui utilise le `slug` de l'article pour afficher l'article complet.
- Une page avec l'article complet
  - Titre
  - Auteur + date
  - Sections clickables s'il y en a
  - Article complet avec retour automatique à la ligne
- Un bouton de connexion vers le formulaire de connexion

**Back End**
- Connexion simple pour les utilisateurs
- Une page d'accueil d'administration avec un menu
- Un `CRUD` fonctionnel sur `Article` **Uniquement pour les utilisateurs avec le rôle `ROLE_ADMIN`**
- Un bouton de déconnexion

## Préparation
- Vérifiez que vous avez bien installé `Docker` sur votre machine
- Vérifiez que `composer` est sur votre machine
- utilisez l'installateur de `Symfony` pour créer un nouveau projet Symfony

## Consignes

Créez un nouveau projet Symfony avec la commande suivante :

```bash
symfony new sym64{Votre-prénom} --version=lts --webapp
```

Créez un répertoire sur github avec le nom `sym64{Votre-prénom}` et envoyer vos fichiers sur ce répertoire.

### Dans le `.env` de votre projet, modifiez la ligne suivante :

```bash
DB_TYPE="mysql"
# DB_NAME="sym64{Votre-prénom}" # Remplacez {Votre-prénom} par votre 
DB_NAME="sym64michael"
# prénom dans majuscules et sans accent
DB_HOST="localhost"
DB_PORT=3306
DB_USER="root"
DB_PWD=""
DB_CHARSET="utf8mb4"

DATABASE_URL="${DB_TYPE}://${DB_USER}:${DB_PWD}@${DB_HOST}:${DB_PORT}/${DB_NAME}?charset=${DB_CHARSET}"
```

Créez la base de données avec la commande suivante :

```bash
php bin/console doctrine:database:create
```

### Créez un contrôleur avec une méthode `index` pour la majeure partie du frontend de votre application

```bash
php bin/console make:controller
```

Donnez le nom `homepage` à cet index et il doit pointer vers la racine de votre site (127.0.0.1:8000 généralement).

### Créez un User avec la commande suivante :

```bash

 php bin/console make:user

 The name of the security user class (e.g. User) [User]:
 >

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 >

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 > username

 Will this app need to hash/check user passwords? Choose No if passwords are not needed or will be checked/hashed by some other system (e.g. a single sign-on server).   

 Does this app need to hash/check user passwords? (yes/no) [yes]:

```

Vous pouvez maintenant créer la table de votre User avec la commande suivante :

```bash
php bin/console make:migration
# puis 
php bin/console doctrine:migrations:migrate
```

Il faut ensuite faire un make:entity pour compléter l'entité `User` pour obtenir les champs suivants dans la table `user` :

```mysql
-- -----------------------------------------------------
-- Table `sym64michael`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym64michael`.`user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(180) NOT NULL,
  `roles` JSON NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `fullname` VARCHAR(150) NULL,
  `uniqid` VARCHAR(60) NOT NULL,
  `email` VARCHAR(180) NOT NULL,
  `activate` TINYINT UNSIGNED NOT NULL DEFAULT 0-- boolean false
    ,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `UNIQ_IDENTIFIER_USERNAME` (`username` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;
```

### Créez une Entité `Article` avec la commande suivante :

```bash
php bin/console make:entity Article

```

Pour obtenir en base de données la table suivante :

```mysql
-- -----------------------------------------------------
-- Table `sym64michael`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym64michael`.`article` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(160) NOT NULL,
    `title_slug` VARCHAR(162) NOT NULL,
    `text` LONGTEXT NOT NULL,
    `article_date_create` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `article_date_posted` DATETIME NULL DEFAULT NULL,
    `published` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    UNIQUE INDEX `UNIQ_23A0E66D347411D` (`title_slug` ASC) VISIBLE,
    INDEX `IDX_23A0E66A76ED395` (`user_id` ASC) VISIBLE,
    CONSTRAINT `FK_23A0E66A76ED395`
      FOREIGN KEY (`user_id`)
        REFERENCES `sym64michael`.`user` (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
```

### Créez une Entité `Section` avec la commande suivante :

```bash
php bin/console make:entity
```

Pour obtenir la table suivante en base de données :

```mysql
-- -----------------------------------------------------
-- Table `sym64michael`.`section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym64michael`.`section` (
      `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `section_title` VARCHAR(100) NOT NULL,
      `section_slug` VARCHAR(105) NOT NULL,
      `section_detail` VARCHAR(500) NULL DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `UNIQ_2D737AEF1D237769` (`section_slug` ASC) VISIBLE)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;
```

### Créez d'un `manytomany` de `Article` vers `Section` :

```bash
php bin/console make:entity Article
```

Puis migration la table :

```bash
php bin/console make:migration
# puis
php bin/console doctrine:migrations:migrate
```

### Mysql m2m

```mysql
-- -----------------------------------------------------
-- Table `sym64michael`.`article_section`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sym64michael`.`article_section` (
  `article_id` INT UNSIGNED NOT NULL,
  `section_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`article_id`, `section_id`),
  INDEX `IDX_C0A13E587294869C` (`article_id` ASC) VISIBLE,
  INDEX `IDX_C0A13E58D823E37A` (`section_id` ASC) VISIBLE,
  CONSTRAINT `FK_C0A13E587294869C`
    FOREIGN KEY (`article_id`)
    REFERENCES `sym64michael`.`article` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `FK_C0A13E58D823E37A`
    FOREIGN KEY (`section_id`)
    REFERENCES `sym64michael`.`section` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;
```

### Base de donnée minimale :

![base de donnée minimale](https://raw.githubusercontent.com/devWebCF2m/prepaTIsymdocker/refs/heads/main/datas/sym64michael.png)

### Créez une Fixture pour toutes les entités :


#### Installez le package `orm-fixtures` :

```bash
composer require orm-fixtures --dev 
```

#### Importez Faker :

```bash
composer require fakerphp/faker
 ```

Documentation : https://fakerphp.org/

#### Importez Slugify :

```bash
composer require cocur/slugify
```

Documentation : https://github.com/cocur/slugify


### Créez les fixtures :

Dans le fichier `src/DataFixtures/AppFixtures.php` :

#### Il nous faut 30 utilisateurs 
Mots de passe hachés ! Utilisation de `Slugify` pour le `username`, `Faker` pour le `fullname` et `email`, le `password` doit être haché avec `UserPasswordHasherInterface` et le `uniqid` doit être généré avec `uniqid()` :

- **1** `ROLE_ADMIN` avec comme login et mot de passe `admin` et `admin` actif, 
- **5** `ROLE_REDAC` avec comme login et mot de passe `redac{1 à 5}` et `redac{1 à 5}`  correspondants et actifs
- **24** `ROLE_USER` avec comme login et mot de passe `user{1 à 24}` et `user{1 à 24}` et **3 sur 4 actifs** ! Ne peuvent pas écrire d'articles !


#### Il nous faut 160 articles  
Utilisation de `Faker` pour le titre, puis `slugify` pour TitleSlug à partir du titre, `Faker` pour le texte, une date **entre 6 mois et maintenant** pour la date de **création**, **une date après la date de création pour la date de publication si l'article est publié (3 chances sur 4)** (voir `$faker->dateTimeBetween`), un auteur aléatoire (dans `ROLE_ADMIN` ou `ROLE_REDAC`).

#### Il nous faut 6 sections
Utilisation de `Faker` pour le titre, puis `slugify` pour SectionSlug à partir du titre, `Faker` pour le texte.
Il faut ajouter au **hasard entre 2 et 40 articles par section** !


### Choisissez un template et utiliser le sur votre projet

Vous pouvez utiliser un template gratuit de votre choix, responsive, et utiliser `Twig` pour l'intégrer dans votre projet. N'utilisez pas le même template que l'exemple donné !

### Créez un formulaire de connexion

Pour le formulaire de connexion, vous pouvez utiliser le formulaire de base de `Symfony` ou un formulaire `Twig` avec les champs `username` et `password` et un bouton `Connexion`.

L'authentification se fera avec le `username` et le `password` de l'entité `User`.


### Créez une administration

Créez une administration avec un CRUD sur les articles, uniquement pour les utilisateurs avec le rôle `ROLE_ADMIN`.

Vous pouvez utiliser l'exemple donné pour savoir ce que vous devez faire pour obtenir le TI minimum :

[sym64simple.cf2m.be](https://sym64simple.cf2m.be/)

## Respectez les consignes

Il y a peu de consignes, mais elles sont importantes :
respectez les **AVANT** de faire les bonus !
Je dois pouvoir vérifier le **TI** avec le rôle `ROLE_ADMIN`  que vous avez créé (`admin`, `admin`,).

## Bonus

Ce **TI** est déjà assez complet (dans le temps qui vous est donné) pour vérifier vos compétences de bases en `Symfony`, `Twig` et `Doctrine`, mais si vous avez du temps, vous pouvez ajouter des fonctionnalités supplémentaires :

### Niveau 1

**Back End**

- Ajouter un `CRUD` fonctionnel sur les `Sections` pour les utilisateurs avec le rôle `ROLE_ADMIN`
- Ajouter un `CRUD` fonctionnel sur les `Users` pour les utilisateurs avec le rôle `ROLE_ADMIN`

**Front End**

- Faites en sorte que les `fullname` soient cliquables et renvoient vers une page avec le détail du `User` et les  `articles` de cet `auteur`

#### Niveau 2

**Back End**

- Permettez un `CRUD` sur les `Articles` pour les utilisateurs avec le rôle `ROLE_REDAC`, ! Mais uniquement sur les articles qu'ils ont écrits ! Ils ne peuvent créer des articles qu'avec leur `username` comme auteur !

#### Niveaux 3 - 4

- Tentez l'inscription par mail, les commentaires comme sur :

https://sym6.cf2m.be/

- Tout ce que vous souhaitez essayer dans le temps imparti !

Installez des Bundles d'administration comme `EasyAdmin` ou `SonataAdmin` pour gérer les `CRUD` plus facilement.

https://github.com/mikhawa/symfony-2023-05-10


Bon boulot !