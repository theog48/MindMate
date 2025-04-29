<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\QuizzType;
use App\Repository\QuizzRepository;
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

    #[Route('/{id}/submit', name: 'app_quizz_submit_response', methods: ['POST'])]
    public function submitResponse(Request $request, Quizz $quizz): Response
    {
        $score = $request->request->getInt('score');

        return $this->redirectToRoute('app_quizz_results', [
            'id' => $quizz->getId(),
            'score' => $score,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_quizz_delete', methods: ['POST'])]
    public function delete(Request $request, Quizz $quizz, EntityManagerInterface $entityManager): Response
    {
        $score = $request->query->getInt('score');

        // Récupération des questions et des réponses
        $questions = [
            ['question' => $quizz->getQuestion1(), 'reponse1' => $quizz->getReponse11(), 'reponse2' => $quizz->getReponse12(), 'reponse3' => $quizz->getReponse13(), 'bonneReponse' => $quizz->getBonnereponse1(), 'userReponse' => $quizz->getUserreponse1()],
            ['question' => $quizz->getQuestion2(), 'reponse1' => $quizz->getReponse21(), 'reponse2' => $quizz->getReponse22(), 'reponse3' => $quizz->getReponse23(), 'bonneReponse' => $quizz->getBonneReponse2(), 'userReponse' => $quizz->getReponseUser2()],
            ['question' => $quizz->getQuestion3(), 'reponse1' => $quizz->getReponse31(), 'reponse2' => $quizz->getReponse32(), 'reponse3' => $quizz->getReponse33(), 'bonneReponse' => $quizz->getBonneReponse3(), 'userReponse' => $quizz->getReponseUser3()],
            ['question' => $quizz->getQuestion4(), 'reponse1' => $quizz->getReponse41(), 'reponse2' => $quizz->getReponse42(), 'reponse3' => $quizz->getReponse43(), 'bonneReponse' => $quizz->getBonneReponse4(), 'userReponse' => $quizz->getReponseUser4()],
            ['question' => $quizz->getQuestion5(), 'reponse1' => $quizz->getReponse51(), 'reponse2' => $quizz->getReponse52(), 'reponse3' => $quizz->getReponse53(), 'bonneReponse' => $quizz->getBonneReponse5(), 'userReponse' => $quizz->getReponseUser5()],
        ];

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

        $quizz->setUserreponse1($data->get('userreponse1'));
        $quizz->setReponseUser2($data->get('reponseUser2'));
        $quizz->setReponseUser3($data->get('reponseUser3'));
        $quizz->setReponseUser4($data->get('reponseUser4'));
        $quizz->setReponseUser5($data->get('reponseUser5'));

        $quizz->setScore($score);

        $em->flush();

        // REDIRECT vers page de résultats
        return $this->redirectToRoute('app_quizz_results', [
            'id' => $quizz->getId(),
        ]);
    }

    #[Route('/{id}/results', name: 'app_quizz_results', methods: ['GET'])]
    public function results(Quizz $quizz): Response
    {
        return $this->render('quizz/results.html.twig', [
            'quizz' => $quizz,
        ]);
    }
}
