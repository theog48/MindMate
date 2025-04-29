<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\SecurityBundle\Security;

class SecurityController extends AbstractController
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private RequestStack $requestStack
    ) {}

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security, EntityManagerInterface $entityManager): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        /** @var User|null $user */
        $user = $security->getUser();

        if ($user) {
            // Vérifie si la date de fin du premium est dépassée
            if ($user->hasTestPremium() && $user->getDateFinPremium() instanceof \DateTimeInterface) {
                if ($user->getDateFinPremium() <= new \DateTimeImmutable()) {
                    $user->setHasTestPremium(false);

                    // Met à jour les rôles
                    $roles = array_values(array_diff($user->getRoles(), ['ROLE_PAID']));

                    if (!in_array('ROLE_USER', $roles)) {
                        $roles[] = 'ROLE_USER';
                    }

                    $user->setRoles(array_values($roles));

                    $entityManager->persist($user);
                    $entityManager->flush();

                    // Rafraîchir le token pour appliquer les nouveaux rôles immédiatement
                    $token = new UsernamePasswordToken($user, 'main', $roles);
                    $this->tokenStorage->setToken($token);
                    $this->requestStack->getSession()->set('_security_main', serialize($token));
                }
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
