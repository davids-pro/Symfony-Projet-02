<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use app\Entity\Post;
use DateTime;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $article = new Post();
        $article->setTitle('Report Cyberpunk 2077');
        $article->setDateCreated(new DateTime());
        $article->setContent("CD Projekt Red a pris la décision de repousser Cyberpunk 2077, le jeu le plus attendu de l'année 2020. Rendez-vous donc le 17 septembre 2020.");
        $article->setEnable(true);
        $manager->persist($article);

        $manager->flush();
    }
}
