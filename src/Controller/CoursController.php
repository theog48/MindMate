<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Quizz;
use App\Entity\User;
use App\Form\CoursType;
use App\Repository\CoursRepository;
use App\Service\CoursService;
use App\Repository\QuizzRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
    public function new(Request $request, EntityManagerInterface $entityManager, CoursRepository $coursRepository, QuizzRepository $quizzRepository): Response
    {
        $reponse = '';
        $cour = new Cours();
        $quizz = new Quizz();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);
        $response = '';
    
     
        if ($form->isSubmitted() && $form->isValid()) {
            if ($request->isMethod('POST')) {
                $cour->setCreatedAt(new \DateTimeImmutable());
                $title = $cour->getTitre();
                $description = $cour->getContenu();
    
                // Vérification de la longueur du contenu
                if (empty($description) || strlen($description) < 10 || strlen($description) > 5000) {
                    echo "<script>alert('Le contenu du cours doit contenir entre 10 et 5000 caractères.');</script>";
                    return $this->render('cours/new.html.twig', [
                        'form' => $form,
                        'response' => $response,
                    ]);
                }
                $client = HttpClient::create();
                $token = $_ENV['MISTRAL_API_KEY'];
    
                try {
                    $response = $client->request('POST', 'https://api.mistral.ai/v1/chat/completions', [
                        'headers' => [
                            'Authorization' => 'Bearer ' . $token,
                            'Content-Type' => 'application/json',
                        ],
                        'json' => [
                            "messages" => [
                                [
                                    "role" => "user",
                                    "content" => "Je veux un cours sur le sujet suivant : $title. Voici le contenu du cours à résumer et à simplifier : $description. Je voudrais également 5 questions de type QCM avec 3 choix possibles et je voudrais également la bonne réponse. Fais-moi une réponse sous forme de JSON dont voici un exemple :{
                                        [\"cours\"]=> {
                                            [\"title\"]=>\"titre du cours\"
                                            [\"content\"]=>\"Résumé du cours\"
                                        }
                                        [\"questions\"]=>{
                                            [0]=>{
                                                [\"question\"]=>\"En quelle année Lady Diana s'est-elle mariée au prince Charles?\"
                                                [\"choices\"]=>{
                                                    [0]=>\"1980\"
                                                    [1]=>\"1981\"
                                                    [2]=>\"1982\"
                                                }
                                                [\"correct_answer\"]=>\"1981\"
                                            }
                                            [1]=>{
                                                [\"question\"]=>\"Quel surnom a été donné à Lady Diana?\"
                                                [\"choices\"]=>{
                                                    [0]=>\"La princesse du soleil\"
                                                    [1]=>\"La princesse du peuple\"
                                                    [2]=>\"La princesse de la paix\"
                                                }
                                                [\"correct_answer\"]=>\"La princesse du peuple\"
                                            }
                                            [2]=>{
                                                [\"question\"]=>\"Quelle cause caritative a été particulièrement défendue par Lady Diana?\"
                                                [\"choices\"]=>{
                                                    [0]=>\"La conservation des forêts\"
                                                    [1]=>\"La lutte contre le SIDA\"
                                                    [2]=>\"La protection des animaux\"
                                                }
                                                [\"correct_answer\"]=>\"La lutte contre le SIDA\"
                                            }
                                            [3]=>{
                                                [\"question\"]=>\"En quelle année Lady Diana est-elle décédée?\"
                                                [\"choices\"]=>{
                                                    [0]=>\"1996\"
                                                    [1]=>\"1997\"
                                                    [2]=>\"1998\"
                                                }
                                                [\"correct_answer\"]=>\"1997\"
                                            }
                                            [4]=>{
                                                [\"question\"]=>\"Comment Lady Diana a-t-elle brisé des tabous dans ses actions caritatives?\"
                                                [\"choices\"]=>{
                                                    [0]=>\"En parlant ouvertement de la pauvreté\"
                                                    [1]=>\"En touchant des patients atteints du SIDA et en marchant dans des champs de mines\"
                                                    [2]=>\"En soutenant les droits des enfants\"
                                                }
                                                [\"correct_answer\"]=>\"En touchant des patients atteints du SIDA et en marchant dans des champs de mines\"
                                            }
                                        }
                                    }"
                                ]
                            ],
                            "model" => "mistral-large-latest",
                        ],
                    ]);
                } catch (TransportExceptionInterface $e) {
                    dd("Transport error: " . $e->getMessage());
                } catch (\Exception $e) {
                    dd("Error: " . $e->getMessage());
                }
                
                $jsonString = $response->getContent();
                $json = json_decode($jsonString, true);
                
                if (!isset($json['choices'][0]['message']['content'])) {
                    dd("Erreur : Réponse inattendue de l'API", $json);
                }
                
                $reponseStr = $json['choices'][0]['message']['content'];
                $reponseStr = preg_replace('/```json\s*|\s*```/', '', $reponseStr);
                $reponseJson = json_decode($reponseStr, true);
                echo "<pre>";
                var_dump($json['usage']['total_tokens']);
                echo "</pre>";
                $newTokens = $json['usage']['total_tokens'];
    
                if (!isset($reponseJson['cours'])) {
                    dd("Erreur : La clé 'cours' est absente du JSON", $reponseJson);
                }
    
                $titre = $reponseJson['cours']['title'];
                $contenu = $reponseJson['cours']['content'];
                $questions = $reponseJson['questions'];
    
                $cour->setTitre($titre);
                $cour->setContenu($contenu);
                $quizz->setTitre($titre);
                $quizz->setQuestion1($questions[0]['question']);
                $quizz->setReponse11($questions[0]['choices'][0]);
                $quizz->setReponse12($questions[0]['choices'][1]);
                $quizz->setReponse13($questions[0]['choices'][2]);
                $quizz->setBonneReponse1($questions[0]['correct_answer']);
                $quizz->setQuestion2($questions[1]['question']);
                $quizz->setReponse21($questions[1]['choices'][0]);
                $quizz->setReponse22($questions[1]['choices'][1]);
                $quizz->setReponse23($questions[1]['choices'][2]);
                $quizz->setBonneReponse2($questions[1]['correct_answer']);
                $quizz->setQuestion3($questions[2]['question']);
                $quizz->setReponse31($questions[2]['choices'][0]);
                $quizz->setReponse32($questions[2]['choices'][1]);
                $quizz->setReponse33($questions[2]['choices'][2]);
                $quizz->setBonneReponse3($questions[2]['correct_answer']);
                $quizz->setQuestion4($questions[3]['question']);
                $quizz->setReponse41($questions[3]['choices'][0]);
                $quizz->setReponse42($questions[3]['choices'][1]);
                $quizz->setReponse43($questions[3]['choices'][2]);
                $quizz->setBonneReponse4($questions[3]['correct_answer']);
                $quizz->setQuestion5($questions[4]['question']);
                $quizz->setReponse51($questions[4]['choices'][0]);
                $quizz->setReponse52($questions[4]['choices'][1]);
                $quizz->setReponse53($questions[4]['choices'][2]);
                $quizz->setBonneReponse5($questions[4]['correct_answer']);
                $quizz->setCours($cour);
    
                $user = $this->getUser();
                if($user instanceof User) {
                    $user->setNbToken($user->getNbToken() - $newTokens);
                } 
                
                $quizz->setUser($user);
                $cour->setUser($user);
                $entityManager->persist($quizz);
                $entityManager->persist($cour);
                $entityManager->flush();
    
                return $this->render('cours/new.html.twig', [
                    'form' => $form,
                    'response' => $response,
                    'token' => $token,
                ]);
            }
        }
    
        return $this->render('cours/new.html.twig', [
            'form' => $form,
            'response' => $response,
        ]);
    }

    #[Route('/generer', name: 'app_cours_generer', methods: ['GET'])]
    public function generer(Request $request, CoursService $coursService, EntityManagerInterface $em): Response
    {
        $sujet = $request->query->get('sujet', 'Programmation orientée objet');

        $donnees = $coursService->genererCours($sujet);

        $cours = new Cours();
        $cours->setTitre($donnees['cours']['titre'] ?? $sujet);
        $cours->setContenu(json_encode($donnees, JSON_PRETTY_PRINT)); // ou extraire un champ précis
        $cours->setCreatedAt(new \DateTime());

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
        if ($this->isCsrfTokenValid('delete' . $cour->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
