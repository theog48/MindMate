<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
// use GuzzleHttp\Client;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
    public function new(Request $request, EntityManagerInterface $entityManager, CoursRepository $coursRepository): Response
    {
        $reponse ='';
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);
        $cour->setCreatedAt(new \DateTimeImmutable());
        $response = '';


        if($request->isMethod('POST')) {
            $title = $request->request->get('titre');
            $description = $request->request->get('contenu');
            $client = HttpClient::create();
            $token = $_ENV['MISTRAL_API_KEY'];
            // try{

            //     $response = $client->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
            //         'headers' => [
            //             'Authorization' => 'Bearer ' . $token,
            //             'Content-Type' => 'application/json',
            //         ],
            //         'json' => [
            //             "messages" => [
            //                 [
            //                     "role" => "user",
            //                     "content" => "Je veux un cours sur le sujet suivant : $title. Voici le contenu du cours : $description"
            //                 ]
            //             ],
            //             "model" => "mistral-large-latest",
            //         ],
            //     ]
            //     );
            // } catch(TransportExceptionInterface $e){
            //     dd("Transport error: " . $e->getMessage());
            // } catch(\Exception $e){
            //     dd("Error: " . $e->getMessage());
            // }
            echo '<pre>';
            var_dump($title);
            var_dump($description);
            echo '</pre>';
            return $this->render('cours/new.html.twig', [
                'form' => $form,
                'response' => $response,
                'token' => $token,
            ]);
        }


        return $this->render('cours/new.html.twig', [
            'form' => $form,
            'response' => $response,

            // 'reponse' => $reponse,
        ]);

        // $cour = new Cours();
        // $form = $this->createForm(CoursType::class, $cour);
        // $form->handleRequest($request);
        // $cour->setCreatedAt(new \DateTimeImmutable());

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager->persist($cour);
        //     $entityManager->flush();

        //     return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
        // }

        // return $this->render('cours/new.html.twig', [
        //     'cour' => $cour,
        //     'form' => $form,
        // ]);
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
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
