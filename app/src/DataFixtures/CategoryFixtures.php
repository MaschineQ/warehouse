<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $category1 = new Category();
        $category1->setName('Agro');
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName('Cosmetics');
        $manager->persist($category2);

        $manager->flush();
    }
}
