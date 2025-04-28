<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SupportType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;

final class SupportController extends AbstractController
{
    #[Route('/support', name: 'app_support')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $user = $this->getUser();
        if ($user instanceof User === null) {
            return $this->redirectToRoute('app_login');
        }
        if($user instanceof User){
            $email = $user->getEmail();
        }


        $form = $this->createForm(SupportType::class);
        $form->handleRequest($request);
        $formData = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $email = (new Email())
            ->from($email)
            ->to('support.mindmate@protonmail.com')
            ->subject($formData['objet'])
            ->text($formData['message'])
            ->html('<p>Contenu HTML de l\'email</p>');

        $mailer->send($email);
        }

        return $this->render('support/index.html.twig', [
            'controller_name' => 'SupportController',
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
