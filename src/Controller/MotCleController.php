<?php

namespace App\Controller;

use App\Entity\MotCle;
use App\Form\MotCleType;
use App\Repository\MotCleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mot/cle')]
final class MotCleController extends AbstractController
{
    #[Route(name: 'app_mot_cle_index', methods: ['GET'])]
    public function index(MotCleRepository $motCleRepository): Response
    {
        return $this->render('mot_cle/index.html.twig', [
            'mot_cles' => $motCleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_mot_cle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $motCle = new MotCle();
        $form = $this->createForm(MotCleType::class, $motCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($motCle);
            $entityManager->flush();

            return $this->redirectToRoute('app_mot_cle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mot_cle/new.html.twig', [
            'mot_cle' => $motCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mot_cle_show', methods: ['GET'])]
    public function show(MotCle $motCle): Response
    {
        return $this->render('mot_cle/show.html.twig', [
            'mot_cle' => $motCle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mot_cle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MotCle $motCle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MotCleType::class, $motCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_mot_cle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mot_cle/edit.html.twig', [
            'mot_cle' => $motCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mot_cle_delete', methods: ['POST'])]
    public function delete(Request $request, MotCle $motCle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$motCle->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($motCle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_mot_cle_index', [], Response::HTTP_SEE_OTHER);
    }
}
