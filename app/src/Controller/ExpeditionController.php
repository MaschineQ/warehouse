<?php

namespace App\Controller;

use App\Entity\Expedition;
use App\Entity\ExpeditionItem;
use App\Form\ExpeditionType;
use App\Manager\ExpeditionManager;
use App\Repository\ExpeditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExpeditionController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/expedition', name: 'app_expedition')]
    public function index(ExpeditionRepository $expeditions): Response
    {
        return $this->render('expedition/index.html.twig', [
            'expeditions' => $expeditions->findAll(),
        ]);
    }

    #[Route('/expedition/add', name: 'app_expedition_add', priority: 2)]
    public function add(
        Request              $request,
        ExpeditionRepository $expeditions,
        ExpeditionManager    $expeditionManager
    ): Response {
        $form = $this->createForm(ExpeditionType::class, new Expedition());


        $form->handleRequest($request);
        /** @var Expedition $expedition */
        $expedition = $form->getData();

        $product = $expedition->getProduct();

        if (null !== $product) {
            if (!$expeditionManager->isRightNumberOfPiecesPerUnit(
                $expeditionManager->getnumberOfPiecesPerUnit(
                    $expedition->getQuantity(),
                    $product->getQuantityPerPiece()
                ),
                $expedition->getQuantity()
            )) {
                $form->addError(
                    new FormError(
                        $this->translator->trans(
                            'The quantity does not match the package.',
                            [
                                '%quantityPerPiece%' => $product->getQuantityPerPiece(),
                                '%packagingType%' => $product->getPackagingType()
                            ],
                            'validators'
                        )
                    )
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

            if (null !== $product) {
                $numberOfPieces = $product->getPackaging() - ($expedition->getQuantity() / $product->getQuantityPerPiece());
                $labelQuantity = $product->getLabel() - ($expedition->getQuantity() / $product->getQuantityPerPiece());

                $product->setPackaging((int)$numberOfPieces);
                $product->setLabel((int)$labelQuantity);

                $expeditions->add($expedition, true);

                $this->addFlash('succecs', $this->translator->trans('Expedition have been added.'));
            } else {
                $this->addFlash('succecs', $this->translator->trans('An error has occured.'));
            }
            return $this->redirectToRoute('app_expedition');
        }

        return $this->render('expedition/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
