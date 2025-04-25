<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cours')]
final class CoursController extends AbstractController
{
    #[Route(name: 'app_cours_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('cours/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $cours = new Cours();
        $cours->setUser($this->getUser());  // Assigner l'utilisateur connecté automatiquement

        // Formulaire sans champs de date ni user_id
        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cours->setCreatedAt(new \DateTime()); // Assigner la date actuelle automatiquement

            $em->persist($cours);
            $em->flush();

            $this->addFlash('success', 'Cours créé avec succès.');

            return $this->redirectToRoute('app_cours_index');
        }

        return $this->render('cours/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/generer', name: 'app_cours_generer', methods: ['GET'])]
    public function generer(Request $request, CoursService $coursService, EntityManagerInterface $em): Response
    {
        $sujet = $request->query->get('sujet', 'Programmation orientée objet');

        $donnees = $coursService->genererCours($sujet);

        $cours = new Cours();
        $cours->setTitre($donnees['cours']['titre'] ?? $sujet);
        $cours->setContenu(json_encode($donnees, JSON_PRETTY_PRINT));
        $cours->setCreatedAt(new \DateTime());
        $cours->setUser($this->getUser()); // Lier l'utilisateur connecté

        $em->persist($cours);
        $em->flush();

        $this->addFlash('success', 'Cours généré avec succès à partir de Mistral !');

        return $this->redirectToRoute('app_cours_index');
    }

    #[Route('/{id}', name: 'app_cours_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cours_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        // Vérifier si le CSRF token est valide
        if ($this->isCsrfTokenValid('delete' . $cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
            $this->addFlash('success', 'Cours supprimé avec succès.');
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
