<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['test-data'];
    }

    public function load(ObjectManager $manager): void
    {
        $category = $manager->getRepository(Category::class);

        $product = new Product();
        $product->setName('Tee');
        $product->setQuantity(100);
        $product->setPackaging(100);
        $product->setLabel(100);
        $product->setPackagingType('l');
        $product->setQuantityPerPiece(10);
        $product->setCategory($category->findOneByName('Drinks') ?? throw new \Exception('Category not found'));

        $manager->persist($product);

        $manager->flush();
    }
}
