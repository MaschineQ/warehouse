<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class CategoryController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categories): Response
    {
        return $this->render('category/index.html.twig', [
            'categories' => $categories->findAll(),
        ]);
    }

    #[Route('/category/add', name: 'app_category_add', priority: 2)]
    #[IsGranted('ROLE_ADMIN')]
    public function add(Request $request, CategoryRepository $categories): Response
    {
        $form = $this->createForm(CategoryType::class, new Category());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Category $category */
            $category = $form->getData();

            $categories->add($category, true);
            $this->addFlash('succecs', $this->translator->trans('Category have been added.'));
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/category/{category}/edit', name: 'app_category_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, CategoryRepository $categories, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Category $category */
            $category = $form->getData();
            $categories->add($category, true);

            $this->addFlash('success', $this->translator->trans('Your category have been updated.'));

            return $this->redirectToRoute('app_category');
        }

        return $this->render(
            'category/edit.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category
            ]
        );
    }
}
