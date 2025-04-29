namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData(); // 👈 Ici on récupère les champs

            $email = (new Email())
                ->from($formData['email']) // L'email que la personne a entré
                ->to('support.mindmate@protonmail.com')
                ->subject('Message de contact : ' . $formData['nom'])
                ->text($formData['message'])
                ->html('<p>' . nl2br(htmlspecialchars($formData['message'])) . '</p>');

            $mailer->send($email);

            $this->addFlash('success', 'Ton message a été envoyé comme un pigeon voyageur numérique !');
        }

        return $this->render('contact/index.html.twig', [
            'formulaire_contact' => $form->createView(),
        ]);
    }
}
