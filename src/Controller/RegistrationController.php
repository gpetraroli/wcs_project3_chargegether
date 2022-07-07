<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
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

            $email = (new Email())
            ->from('contact@chargether.com')
            ->to('you@example.com')
            ->subject('Inscription sur notre Site Chargether')
            ->text('Sending emails is fun again!')
            ->html('<h1>Activez votre compte</h1>
            <p>Bonjour,</p>
            <p>Votre Inscription sur le Site de
                <strong>CHARGETHER</strong>
                est à valider, en cliquant sur le lien ci-dessous :</p>
            <p>
                <a href="">Lien</a>
            </p>
            <p>Ce lien expirera dans 3 heures.</p>');

        $mailer->send($email);

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}
