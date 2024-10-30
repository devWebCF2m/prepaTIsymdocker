# Suite

Après le *TI* de la semaine dernière, nous allons installer EasyAdminBundle, un bundle qui permet de générer une interface d'administration pour notre application Symfony.

## Site du TI 2024

https://sym64simple.cf2m.be/

## Installation d'EasyAdminBundle

Pour installer EasyAdminBundle, nous allons suivre la documentation officielle du bundle : 

https://symfony.com/bundles/EasyAdminBundle/current/index.html

### Installation du bundle

```bash
composer require easycorp/easyadmin-bundle
```

### Configuration du bundle

Nous allons créer l'accueil de notre administration via la création du dashboard.

```bash
php bin/console make:admin:dashboard
```