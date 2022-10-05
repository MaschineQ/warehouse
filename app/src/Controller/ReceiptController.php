<?php

namespace App\Controller;

use App\Entity\Receipt;
use App\Form\ReceiptType;
use App\Repository\ReceiptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ReceiptController extends AbstractController
{
    public function __construct(
        private TranslatorInterface $translator
    ) {
    }

    #[Route('/receipt', name: 'app_receipt')]
    public function index(ReceiptRepository $receipts): Response
    {
        return $this->render('receipt/index.html.twig', [
            'receipts' => $receipts->findAll(),
        ]);
    }

    #[Route('/receipt/add', name: 'app_receipt_add', priority: 2)]
    public function add(Request $request, ReceiptRepository $receipts): Response
    {
        $form = $this->createForm(ReceiptType::class, new Receipt());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Receipt $receipt */
            $receipt = $form->getData();

            $product = $receipt->getProduct();

            $product->setPackaging($product->getPackaging() + $receipt->getPackaging());
            $product->setLabel($product->getLabel() + $receipt->getLabel());


            $receipts->add($receipt, true);
            $this->addFlash('succecs', $this->translator->trans('Receipt have been added.'));
            return $this->redirectToRoute('app_receipt');
        }

        return $this->render('receipt/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
