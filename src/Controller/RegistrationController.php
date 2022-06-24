<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Request;
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
        SendMailService $mail
    ): Response {
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

            $mail->send(
                'contact@chargether.com',
                $user->getEmail(),
                'Votre Inscription sur le site Chargether',
                'register',
                ['user' => $user]
                //compact('user')
            );

            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );


            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('registration/register.html.twig', [
            'form' => $form,
        ]);
    }
}
