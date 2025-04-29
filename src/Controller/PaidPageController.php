<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PaidType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PaidPageController extends AbstractController
{
    #[Route('/paid/page', name: 'app_paid_page')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(PaidType::class);
        $form->handleRequest($request);
        $formData = $form->getData();
        $nbMois = $formData['NbMois'] ?? null;
        if($form->isSubmitted() && $form->isValid()){
            if($user instanceof User){
                if($user->getDateFinPremium() == null || $user->getDateFinPremium() < new \DateTime()){
                    $newDateFin = new \DateTime();
                    $user->setRoles(['ROLE_PAID']);
                }else{
                    $newDateFin = new \DateTime($user->getDateFinPremium()->format('Y-m-d'));
                }
        
                $newDateFin->modify("+$nbMois month");
                $user->setDateFinPremium($newDateFin);
                $security->login($user, 'form_login', 'main');
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->render('paid_page/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
