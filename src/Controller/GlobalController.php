<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\News;
use App\Form\NewsType;
use App\Repository\ImagesRepository;
use App\Repository\NewsRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function article(NewsRepository $newsRepository, ImagesRepository $imagesRepository)
    {
        $articles = $newsRepository->findAll();
        $images = $imagesRepository->findAll();

        return $this->render('global/articles.html.twig', [
            'controller_name' => 'GlobalController',
            'articles' => $articles,
            'images' => $images
        ]);
    }
    /**
     * @Route("/ajout", name="ajout")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $news = new News();
        $news->setPicture(new Images());
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news->setDate(new DateTime());
            $entityManager->persist($news);
            $entityManager->flush();
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
        $news = $entityManager->getRepository(News::class)->find($id);

        if ($news) {
            $form = $this->createForm(NewsType::class, $news);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager->persist($news);
                $manager->flush();
                return $this->redirectToRoute('articles');
            }
            return $this->render('global/edit.html.twig', [
                'form' => $form->createView(),
                'article' => $news
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
        $article = $entityManager->getRepository(News::class)->find($id);
        if ($article) {
            $entityManager->remove($article);
            $entityManager->flush();
            return $this->redirectToRoute('articles');
        } else {
            return $this->redirectToRoute('articles');
        }
    }
}
