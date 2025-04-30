<?php

// ProfilController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

final class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {
        // Get the logged-in user
        $user = $this->getUser();
        $cours = [];
        // Get the courses related to the logged-in user
        if($user instanceof User){
            $cours = $user->getCours();
        }

        return $this->render('profil/index.html.twig', [
            'user' => $user,
            'cours' => $cours,  // Pass courses to the template
        ]);
    }

    #[Route('/profil/{id}/edit', name: 'app_profil_edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $em): Response
    {
        // Check if the user is editing their own profile
        if ($user !== $this->getUser()) {
            throw new AccessDeniedException('You can only edit your own profile.');
        }

        // Simulate update (you can add real form handling logic here)
        $user->setNom('Nom modifié');
        $em->flush();

        $this->addFlash('success', 'Profil modifié avec succès.');
        return $this->redirectToRoute('app_profil');
    }

    #[Route('/profil/{id}/delete', name: 'app_profil_delete', methods: ['POST'])]
    public function delete(User $user, EntityManagerInterface $em): Response
    {
        // Ensure the user can only delete their own profile
        if ($user !== $this->getUser()) {
            throw new AccessDeniedException('You can only delete your own profile.');
        }

        $em->remove($user);
        $em->flush();

        $this->addFlash('success', 'Profil supprimé avec succès.');

        return $this->redirectToRoute('app_logout'); // or homepage
    }

    #[Route('/profil/{id}/show', name: 'app_profil_show')]
    public function show(User $user): Response
    {
        // Check if the user is viewing their own profile
        if ($user !== $this->getUser()) {
            throw new AccessDeniedException('You can only view your own profile.');
        }

        return $this->render('profil/show.html.twig', [
            'user' => $user,
        ]);
}
}