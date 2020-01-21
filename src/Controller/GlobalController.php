<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostCategoryRepository;
use App\Repository\PostRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/articles", name="articles")
     */
    public function article(PostRepository $postRepository)
    {
        $articles = $postRepository->findAll();

        return $this->render('global/articles.html.twig', [
            'controller_name' => 'GlobalController',
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/ajout", name="create-article")
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $article = new Post();
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setDateCreated(new DateTime());
            $article->setEnable(true);
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('articles');
        }
        return $this->render('global/ajout.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
