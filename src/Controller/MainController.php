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
    public function categorie($slug, EntityManagerInterface $entityManager): Response
    {
        // récupération de toutes les catégories pour le menu
        $categories = $entityManager->getRepository(Section::class)->findAll();
        // récupération de la catégorie dont le slug est $category_slug
        $categorie = $entityManager->getRepository(Section::class)->findOneBy(['sectionSlug' => $slug]);
        // récupération des articles de la catégorie grâce à la relation ManyToMany de categorie vers articles puis prises de valeurs
        $articles = $entityManager->createQueryBuilder()
            ->select('a')
            ->from(Article::class, 'a')
            ->join('a.sections', 's') // Assurez-vous que 'sections' est le bon nom de la relation
            ->where('a.published = :published')
            ->andWhere('s.id = :categoryId')
            ->setParameter('published', true)
            ->setParameter('categoryId', $categorie->getId())
            ->orderBy('a.articleDatePosted', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('main/categorie.html.twig', [
            // on envoie la catégorie à la vue
            'categories' => $categories,
            'categorie' => $categorie,
            'articles' => $articles,
        ]);
    }

    #[Route('/article/{slug}', name: 'article', methods: ['GET', 'POST'])]
    public function article($slug, EntityManagerInterface $entityManager): Response
    {
        // récupération de toutes les catégories pour le menu
        $categories = $entityManager->getRepository(Section::class)->findAll();
        // récupération de l'article dont le slug est $slug
        $article = $entityManager->getRepository(Article::class)->findOneBy(['titleSlug' => $slug]);


        return $this->render('main/article.html.twig', [
            'categories' => $categories,
            'article' => $article,
        ]);
    }
}
