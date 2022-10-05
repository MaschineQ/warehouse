<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Tests\Common\Fixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductTest extends WebTestCase
{
    public function testGetProducts(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        /** @var User $testUser */
        $testUser = $userRepository->findOneByEmail(UserFixtures::FIRST_USER);
        $client->loginUser($testUser);

        $client->request('GET', '/product');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Tee', $response);
        //$this->assertStringContainsString('Cosmetics', $response);
    }

    public function testAddProduct(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        /** @var User $testUser */
        $testUser = $userRepository->findOneByEmail(UserFixtures::FIRST_USER);
        $client->loginUser($testUser);

        $client->request('GET', '/product/add');

        $this->assertResponseIsSuccessful();


        $category = static::getContainer()->get(CategoryRepository::class);
        /** @var Category $category */
        $category = $category->findOneByName('Drinks');

        $form = $client->submitForm('Save', [
            'product[name]' => 'Coffee',
            'product[quantity]' => 100,
            'product[packaging]' => 100,
            'product[label]' => 100,
            'product[packagingType]' => 'l',
            'product[quantityPerPiece]' => 10,
            'product[category]' => $category->getId()
        ]);

        $productRepository = static::getContainer()->get(ProductRepository::class);
        /** @var Product $product */
        $product = $productRepository->findOneByName('Coffee');

        $this->assertEquals('Coffee', $product->getName());
        $this->assertEquals('100', $product->getQuantity());
        $this->assertEquals('100', $product->getPackaging());
        $this->assertEquals('100', $product->getLabel());
        $this->assertEquals('l', $product->getPackagingType());
        $this->assertEquals('10', $product->getQuantityPerPiece());
        $this->assertEquals('Drinks', $category->getName());
    }
}
