<?php

namespace App\Tests\Functional\Controller;

use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use App\Tests\Common\Fixtures\UserFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryTest extends WebTestCase
{
    public function testGetCategories(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(UserFixtures::FIRST_USER);
        $client->loginUser($testUser);

        $client->request('GET', '/category');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Agro', $response);
        $this->assertStringContainsString('Cosmetics', $response);
    }

    public function testCategoryForm(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail(UserFixtures::FIRST_USER);
        $client->loginUser($testUser);

        $client->request('GET', '/category/add');

        $this->assertResponseIsSuccessful();

        $form = $client->submitForm('Save', [
            'category[name]' => 'Cars',
        ]);

        // self::assertFormValue('#form', 'category[name]', 'Cars');

        $categoryRepository = static::getContainer()->get(CategoryRepository::class);
        $category = $categoryRepository->findOneByName('Cars');
        $this->assertEquals('Cars', $category->getName());
    }
}
