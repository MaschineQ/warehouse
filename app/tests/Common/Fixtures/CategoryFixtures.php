<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['test-data'];
    }

    public function load(ObjectManager $manager): void
    {
        $category = new Category();
        $category->setName('Agro');
        $manager->persist($category);
        $manager->flush();

        $category = new Category();
        $category->setName('Cosmetics');
        $manager->persist($category);
        $manager->flush();
    }
}
