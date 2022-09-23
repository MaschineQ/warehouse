<?php

namespace App\Controller;

use App\Repository\ReceiptRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReceiptController extends AbstractController
{
    #[Route('/receipt', name: 'app_receipt')]
    public function index(ReceiptRepository $receipts): Response
    {
        return $this->render('receipt/index.html.twig', [
            'receipts' => $receipts->findAll(),
        ]);
    }
}
