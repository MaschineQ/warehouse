<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }

    public function load(ObjectManager $manager): void
    {
        $product1 = new Product();
        $product1->setName('Fertilizer 1');
        $product1->setQuantity(100);
        $product1->setCategory($manager->getRepository(Category::class)->findOneByName('Agro'));
        $product1->setPackaging(100);
        $product1->setLabel(100);
        $product1->setPackagingType('l');
        $product1->setQuantityPerPiece(10);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Fertilizer 2');
        $product2->setQuantity(100);
        $product2->setCategory($manager->getRepository(Category::class)->findOneByName('Agro'));
        $product2->setPackaging(20);
        $product2->setLabel(10);
        $product2->setPackagingType('l');
        $product2->setQuantityPerPiece(5);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Cream 1');
        $product3->setQuantity(100);
        $product3->setCategory($manager->getRepository(Category::class)->findOneByName('Cosmetics'));
        $product3->setPackaging(100);
        $product3->setLabel(100);
        $product3->setPackagingType('g');
        $product3->setQuantityPerPiece(50);
        $manager->persist($product3);

        $product4 = new Product();
        $product4->setName('Cream 1');
        $product4->setQuantity(100);
        $product4->setCategory($manager->getRepository(Category::class)->findOneByName('Cosmetics'));
        $product4->setPackaging(300);
        $product4->setLabel(300);
        $product4->setPackagingType('g');
        $product4->setQuantityPerPiece(100);
        $manager->persist($product4);

        $manager->flush();
    }
}
