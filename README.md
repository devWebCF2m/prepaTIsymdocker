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
DB_NAME="sym64{Votre-prénom}" // Remplacez {Votre-prénom} par votre prénom dans majuscules et sans accent
DB_HOST="localhost"
DB_PORT=3306
DB_USER="root"
DB_PWD=""
DB_CHARSET="utf8mb4"

DATABASE_URL="${DB_TYPE}://${DB_USER}:${DB_PWD}@${DB_HOST}:${DB_PORT}/${DB_NAME}?charset=${DB_CHARSET}"
```
