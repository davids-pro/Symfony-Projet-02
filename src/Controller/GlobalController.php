<?php

namespace App\Controller;

use App\Repository\PostCategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('global/index.html.twig', [
            'controller_name' => 'GlobalController',
        ]);
    }
    /**
     * @Route("/categories", name="categories")
     */
    public function categorie(PostCategoryRepository $postCategoryRepository)
    {
        $categories = $postCategoryRepository->findAll();

        return $this->render('global/categories.html.twig', [
            'controller_name' => 'GlobalController',
            'categories' => $categories
        ]);
    }
    /**
     * @Route("/articles/", name="articles")
     */
    public function article(PostRepository $postRepository)
    {
        $articles = $postRepository->findAll();

        return $this->render('global/articles.html.twig', [
            'controller_name' => 'GlobalController',
            'articles' => $articles
        ]);
    }
}
