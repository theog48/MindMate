<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\QuizzType;
use App\Repository\QuizzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/quizz')]
final class QuizzController extends AbstractController
{
    #[Route(name: 'app_quizz_index', methods: ['GET'])]
    public function index(QuizzRepository $quizzRepository): Response
    {
        return $this->render('quizz/index.html.twig', [
            'quizzs' => $quizzRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quizz_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $quizz = new Quizz();
        $form = $this->createForm(QuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($quizz);
            $entityManager->flush();

            return $this->redirectToRoute('app_quizz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quizz/new.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quizz_show', methods: ['GET'])]
    public function show(Quizz $quizz): Response
    {
        return $this->render('quizz/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quizz_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quizz $quizz, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuizzType::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_quizz_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('quizz/edit.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quizz_delete', methods: ['POST'])]
    public function delete(Request $request, Quizz $quizz, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $quizz->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($quizz);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_quizz_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/submit', name: 'app_quizz_submit_response', methods: ['POST'])]
    public function submitResponse(Request $request, Quizz $quizz, EntityManagerInterface $em): Response
    {
        $data = $request->request;

        $score = 0;

        if ($data->get('userreponse1') === $quizz->getBonnereponse1()) $score++;
        if ($data->get('reponseUser2') === $quizz->getBonneReponse2()) $score++;
        if ($data->get('reponseUser3') === $quizz->getBonneReponse3()) $score++;
        if ($data->get('reponseUser4') === $quizz->getBonneReponse4()) $score++;
        if ($data->get('reponseUser5') === $quizz->getBonneReponse5()) $score++;

        // Facultatif : enregistrer les réponses de l’utilisateur
        $quizz->setUserreponse1($data->get('userreponse1'));
        $quizz->setReponseUser2($data->get('reponseUser2'));
        $quizz->setReponseUser3($data->get('reponseUser3'));
        $quizz->setReponseUser4($data->get('reponseUser4'));
        $quizz->setReponseUser5($data->get('reponseUser5'));

        $quizz->setScore($score);

        $em->flush();

        // Redirection vers la page de détails du quizz avec le score mis à jour
        return $this->redirectToRoute('app_quizz_show', ['id' => $quizz->getId()]);
    }
}
