<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use app\Entity\PostCategory;

class PostCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $category = new PostCategory();
        $category->setTitle('Actualités');
        $manager->persist($category);

        $manager->flush();
    }
}
