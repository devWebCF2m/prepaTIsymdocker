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

### Affichage de l'administration

Pour afficher l'administration, nous devons nous connecter à l'URL `/admin`.

## Configuration de l'administration

Nous allons maintenant configurer l'administration pour afficher les entités de notre application.

Nous allons commencer par donner 3 liens pour les 3 rôles à nos utilisateurs :

```php
// src/Controller/Admin/DashboardController.php
# ...
#[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        // si non connecté
        if($this->getUser() == null){
            // redirection vers la page de connexion
            return $this->redirectToRoute('app_login');
        // si administrateur
        }elseif (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            // redirection vers la page d'administration
            return $this->redirectToRoute('homepage');
        // si rédacteur
        }elseif (in_array('ROLE_REDAC', $this->getUser()->getRoles())) {

        // si utilisateur
        }else{

        }
# ...
```

### Création de la vue de `admin dashboard`

```twig
{# templates/easyadmin/admin-dashboard.html.twig #}
{% extends '@EasyAdmin/layout.html.twig' %}

{% block main %}
    {# ... #}
{% endblock main %}
```

Et dans `src/Controller/Admin/DashboardController.php` :

```php
// src/Controller/Admin/DashboardController.php
# ...   
        // si administrateur
        }elseif (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            // affichage du dashboard
            return $this->render('easyadmin/admin-dashboard.html.twig', [
                'user' => $this->getUser()
            ]);
# ...
```
