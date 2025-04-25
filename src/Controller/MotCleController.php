<?php

namespace App\Controller;

use App\Entity\MotCle;
use App\Form\MotCleType;
use App\Repository\MotCleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mot-cle')]
final class MotCleController extends AbstractController
{
    #[Route(name: 'app_motcle_index', methods: ['GET'])]
    public function index(MotCleRepository $motCleRepository): Response
    {
        return $this->render('motcle/index.html.twig', [
            'motCles' => $motCleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_motcle_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $motCle = new MotCle();
        $form = $this->createForm(MotCleType::class, $motCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($motCle);
            $entityManager->flush();

            return $this->redirectToRoute('app_motcle_index');
        }

        return $this->render('motcle/new.html.twig', [
            'motCle' => $motCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_motcle_show', methods: ['GET'])]
    public function show(MotCle $motCle): Response
    {
        return $this->render('motcle/show.html.twig', [
            'motCle' => $motCle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_motcle_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MotCle $motCle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MotCleType::class, $motCle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_motcle_index');
        }

        return $this->render('motcle/edit.html.twig', [
            'motCle' => $motCle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_motcle_delete', methods: ['POST'])]
    public function delete(Request $request, MotCle $motCle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $motCle->getId(), $request->get('_token'))) {
            $entityManager->remove($motCle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_motcle_index');
    }
}
