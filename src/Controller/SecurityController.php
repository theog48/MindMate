<?php

namespace App\Controller;

use DateTimeInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $entityManager): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $user = $this->getUser();
        $hasChanged = false;

        if($user instanceof \App\Entity\User){
            if($user->getDateFinPremium() instanceof DateTimeInterface){
                if($user->getDateFinPremium() < new \DateTime()){
                    
                    $user->setHasTestPremium(false);
                    $user->setDateFinPremium(null);
                    $roles =$user->getRoles();
                    $roles = array_filter($roles, function ($role) {
                        return $role !== 'ROLE_PAID';
                    });
                    $user->setRoles($roles);
                    $hasChanged = true;
                }
            }

            if($hasChanged){
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}