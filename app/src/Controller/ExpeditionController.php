<?php

namespace App\Controller;

use App\Entity\Expedition;
use App\Entity\ExpeditionItem;
use App\Form\ExpeditionType;
use App\Repository\ExpeditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpeditionController extends AbstractController
{
    #[Route('/expedition', name: 'app_expedition')]
    public function index(ExpeditionRepository $expeditions): Response
    {
        return $this->render('expedition/index.html.twig', [
            'expeditions' => $expeditions->findAll(),
        ]);
    }

    #[Route('/expedition/add', name: 'app_expedition_add', priority: 2)]
    public function add(Request $request, ExpeditionRepository $expeditions): Response
    {
        $form = $this->createForm(ExpeditionType::class, new Expedition());


        $form->handleRequest($request);
        /** @var Expedition $expedition */
        $expedition = $form->getData();

        $product = $expedition->getProduct();

        // todo refactor
        if (null !== $product) {
            $packagingQuantity = $product->getPackaging() - ($expedition->getQuantity() / $product->getQuantityPerPiece());
            if (floor($packagingQuantity) == $packagingQuantity && $expedition->getQuantity() != 0) {
            } else {
                $form->addError(
                    new FormError(sprintf(
                        "Množství neodpovídá balení. Na jedno balelení je potřeba násobku %u %s.",
                        $product->getQuantityPerPiece(),
                        $product->getPackagingType()
                    ))
                );
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            // todo refactor
            $expeditionItem = new ExpeditionItem();
            $expeditionItem->setProduct($product);
            $expeditionItem->setPackaging(10);
            $expeditionItem->setLabel(10);
            $expeditionItem->setQuantity($expedition->getQuantity());

            $expedition->addItem($expeditionItem);

            $packagingQuantity = $product->getPackaging() - ($expedition->getQuantity() / $product->getQuantityPerPiece());
            $labelQuantity = $product->getLabel() - ($expedition->getQuantity() / $product->getQuantityPerPiece());

            $product->setPackaging($product->getPackaging() - $expedition->getQuantity());
            $product->setLabel($product->getLabel() - $expedition->getQuantity());




            $expeditions->add($expedition, true);

            $this->addFlash('succecs', 'Expedition have been added.');
            return $this->redirectToRoute('app_expedition');
        }

        return $this->render('expedition/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
