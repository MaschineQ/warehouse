<?php

namespace App\Tests\Functional\Form;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\Form\Test\TypeTestCase;

class CategoryTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'name' => 'Hardware',
        ];

        $category = new Category();
        $form = $this->factory->create(CategoryType::class, $category);
        $form->submit($formData);

        /** @var Category $data */
        $data = $form->getData();
        $categoryName = $data->getName();
        self::assertNotEmpty($categoryName);
        self::assertEquals('Hardware', $categoryName);
    }

    public function testCustomFormView(): void
    {
        $formData = new Category();

        $view = $this->factory->create(CategoryType::class, $formData)->createView();

        $this->assertSame('category', $view->vars['name']);
    }
}
