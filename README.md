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

### Suppression des fichiers inutiles

Nous allons supprimer notre ancienne page d'accueil de l'administration et le contrôleur associé, ainsi que le CRUD de la table `Article`.

- src/Controller/AdminArticleController.php
- src/Controller/AdminController.php
- templates/admin/back.menu.html.twig
- templates/admin/index.html.twig
- templates/admin_article/_delete_form.html.twig
- templates/admin_article/_form.html.twig
- templates/admin_article/edit.html.twig
- templates/admin_article/index.html.twig
- templates/admin_article/new.html.twig
- templates/admin_article/show.html.twig

Lorsque nous nous connecterons à l'administration, nous devrions voir un message de bienvenue de `EasyAdmin`.

