<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use App\Entity\Section;


class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $em): Response
    {
        $categories = $em->getRepository(Section::class)->findAll();
        $articles = $em->getRepository(Article::class)->findBy(['published'=>true], ['articleDatePosted' => 'DESC'], 10);
        return $this->render('main/index.html.twig', [
            // on envoie les catégories à la vue
            'categories' => $categories,
            // on envoie les articles à la vue
            'articles' => $articles,
        ]);
    }
    #[Route('/categorie/{slug}', name: 'categorie')]
    public function categorie(Request $request,$slug, EntityManagerInterface $entityManager): Response
    {
        // récupération de toutes les catégories pour le menu
        $categories = $entityManager->getRepository(Section::class)->findAll();
        // récupération de la catégorie dont le slug est $category_slug
        $categorie = $entityManager->getRepository(Section::class)->findOneBy(['sectionSlug' => $slug]);
        // récupération des articles de la catégorie grâce à la relation ManyToMany de categorie vers articles puis prises de valeurs
        $articles = $categorie->getArticles()->getValues();
        // on retire le slug de l'article pour le retour à l'article après connexion
        $request->getSession()->set('slug', false);
        return $this->render('public/categorie.html.twig', [
            // on envoie la catégorie à la vue
            'categories' => $categories,
            'categorie' => $categorie,
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}', name: 'article', methods: ['GET', 'POST'])]
    public function article(Request $request, $slug, EntityManagerInterface $entityManager): Response
    {
        // récupération de toutes les catégories pour le menu
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
        // récupération de l'article dont le slug est $slug
        $article = $entityManager->getRepository(Article::class)->findOneBy(['ArticleSlug' => $slug]);
        // récupération des commentaires de l'article grâce à son id, triés par date de création décroissante
        $commentaires = $entityManager->getRepository(Commentaire::class)
            ->findBy(['CommentaireManyToOneArticle' => $article->getId()], ['CommentaireDateCreate' => 'DESC']);

        // si l'utilisateur est connecté
        if ($this->getUser()) {
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();

            $commentaire = new Commentaire();
            // on lie le commentaire à l'article
            $commentaire->setCommentaireManyToOneArticle($article);
            // on ne publie pas le commentaire par défaut
            $commentaire->setCommentaireIsPublished(false);
            // on lie le commentaire à l'utilisateur
            $commentaire->setUtilisateur($user);
            // on crée le formulaire
            $form = $this->createForm(CommentaireArticleType::class, $commentaire);
            $form->handleRequest($request);

            // si le formulaire est soumis et valide
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($commentaire);
                $entityManager->flush();

                return $this->redirectToRoute('article', ['slug'=>$slug], Response::HTTP_SEE_OTHER);
            }
        } else {
            $form = null;
            // on garde le slug de l'article pour le retour à l'article après connexion
            $request->getSession()->set('slug', $slug);
        }


        return $this->render('public/article.html.twig', [
            'categories' => $categories,
            'article' => $article,
            'form' => $form,
            // on envoie les commentaires à la vue
            'commentaires' => $commentaires,
        ]);
    }
}
