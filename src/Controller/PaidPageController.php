<?php

namespace App\Controller;

use App\Form\PaidType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PaidPageController extends AbstractController
{
    #[Route('/paid/page', name: 'app_paid_page')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(PaidType::class);
        $form->handleRequest($request);
        $formData = $form->getData();
        if($form)

        return $this->render('paid_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
