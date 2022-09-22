<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $products): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $products->findAll(),
        ]);
    }

    #[Route('/product/add', name: 'app_product_add', priority: 2)]
    public function add(Request $request, ProductRepository $products): Response
    {
        $form =$this->createForm(ProductType::class, new Product());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Product $product */
            $product = $form->getData();

            $products->add($product, true);
            $this->addFlash('succecs', 'Product have been added.');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/product/{product}/edit', name: 'app_product_edit')]
    public function edit(Request $request, ProductRepository $products, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();
            $products->add($product, true);

            $this->addFlash('success', 'Your product have been updated.');

            return $this->redirectToRoute('app_product');
        }

        return $this->render(
            'product/edit.html.twig',
            [
                'form' => $form->createView(),
                'product' => $product
            ]
        );
    }
}
