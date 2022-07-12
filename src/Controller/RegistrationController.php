<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UsersRepository $usersRepository,
        MailerInterface $mailer
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_profil_index');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $usersRepository->add($user, true);

            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );

            $email = (new TemplatedEmail())
                ->from('contact@chargether.com')
                ->to($user->getEmail())
                ->subject('Inscription sur notre Site Chargether')
                ->htmlTemplate('emails/register.html.twig')
                ->context([
                    'user' => $user,
                ]);

            $mailer->send($email);

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}
