<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security, EntityManagerInterface $entityManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        /** @var User|null $user */
        $user = $security->getUser();

        if ($user) {
            // Vérifie si l'utilisateur a un test premium actif
            if ($user->HasTestPremium() && $user->getDateFinPremium() instanceof \DateTimeInterface) {
                // Si la date de fin du premium est dépassée, désactive le premium
                if ($user->getDateFinPremium() <= new \DateTimeImmutable()) {
                    // Si l'utilisateur n'a pas payé, désactiver le premium
                    $user->setHasTestPremium(false);

                    // Met à jour la base de données avec la nouvelle valeur pour hasTestPremium
                    $entityManager->persist($user);
                    $entityManager->flush();

                    // Supprimer le rôle 'ROLE_PAID' si l'utilisateur n'a pas payé
                    if (!in_array('ROLE_PAID', $user->getRoles())) {
                        $user->setRoles(array_diff($user->getRoles(), ['ROLE_PAID']));
                        $entityManager->persist($user);
                        $entityManager->flush();
                    }
                }

                // Assurer que l'utilisateur a le rôle 'ROLE_USER' après expiration du test premium
                if (!in_array('ROLE_USER', $user->getRoles())) {
                    $user->setRoles(array_merge($user->getRoles(), ['ROLE_USER']));
                    $entityManager->persist($user);
                    $entityManager->flush();
                }
            }

            // Si l'utilisateur a payé (par exemple via une transaction), on garde le rôle 'ROLE_PAID'
            if (in_array('ROLE_PAID', $user->getRoles())) {
                // Ne fait rien, le rôle "ROLE_PAID" est maintenu pour les utilisateurs payants
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
