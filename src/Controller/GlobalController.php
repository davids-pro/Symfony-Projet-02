<?php

namespace App\Controller;

use App\Entity\Post;
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
    /**
     * @Route("/edit/{id}", name="edition")
     */
    public function update($id, Request $request, EntityManagerInterface $manager)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Post::class)->find($id);

        if ($article) {
            $form = $this->createFormBuilder($article)
                ->add('title', TextType::class, ['data' => $article->getTitle()])
                ->add('content', TextareaType::class, ['data' => $article->getContent()])
                ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($article);
                $manager->flush();
                return $this->redirectToRoute('articles');
            }
            return $this->render('global/edit.html.twig', [
                'form' => $form->createView(),
                'article' => $article
            ]);
        } else {
            return $this->redirectToRoute('articles');
        }
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Post::class)->find($id);
        if ($article) {
            $entityManager->remove($article);
        $entityManager->flush();
        return $this->redirectToRoute('articles');
        } else {
            return $this->redirectToRoute('articles');
        }
    }
}
