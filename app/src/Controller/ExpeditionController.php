<?php

namespace App\Controller;

use App\Entity\Expedition;
use App\Form\ExpeditionType;
use App\Repository\ExpeditionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Expedition $expedition */
            $expedition = $form->getData();


           // dd($expedition);

            //$product = $expedition->getProduct();

            //$product->setPackaging($product->getPackaging() + $expedition->getPackaging());
            //$product->setLabel($product->getLabel() + $expedition->getLabel());

            $expeditions->add($expedition, true);
            $this->addFlash('succecs', 'Expedition have been added.');
            return $this->redirectToRoute('app_expedition');
        }

        return $this->render('expedition/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
