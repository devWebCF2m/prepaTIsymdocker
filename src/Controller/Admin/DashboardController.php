<?php
// src/Controller/Admin/DashboardController.php
namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;

class DashboardController extends AbstractDashboardController
{
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
            // affichage du dashboard
            return $this->render('easyadmin/admin-dashboard.html.twig', [
                'user' => $this->getUser()
            ]);
        // si rédacteur
        }elseif (in_array('ROLE_REDAC', $this->getUser()->getRoles())) {

        // si utilisateur
        }else{

        }

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // titre de la page
            ->setTitle('PrepaTIsymdocker')
            // icône de la page
            ->setFaviconPath('/favicon.ico')
            // thème de la page
            ->setDefaultColorScheme('dark')
            ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil Admin', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fa fa-tags', Article::class);
    }
}
