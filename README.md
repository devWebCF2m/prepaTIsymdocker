# prepaTIsymdocker

## Repository de consignes

Ce repository contient les consignes pour le TP de préparation à l'installation de Symfony avec Docker.

## Gardez ce répertoire ouvert dans un onglet de votre navigateur

## Préparation
- Vérifiez que vous avez bien installé `Docker` sur votre machine
- Vérifiez que `composer est sur votre machine
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

Donnez le nom `homepage` à cet index et la racine de votre site.

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
