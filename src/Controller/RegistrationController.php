<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class RegistrationController extends AbstractController
{
    #[Route('/verify', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, UsersRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $userRepository->find($request->query->get('id'));
        if (!$user) {
            throw $this->createNotFoundException();
        }
        try {
            $verifyEmailHelper->validateEmailConfirmation(
                $request->getUri(),
                strval($user->getId()),
                $user->getEmail(),
            );
        } catch (VerifyEmailExceptionInterface $e) {
            $this->addFlash('danger', $e->getReason());
        }

        $user->setIsVerified(true);
        $entityManager->flush();
        $this->addFlash('success', 'Account Verified! You can now log in.');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/inscription', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UsersRepository $usersRepository,
        MailerInterface $mailer,
        VerifyEmailHelperInterface $verifyEmailHelper,
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

            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                strval($user->getId()),
                $user->getEmail(),
                ['id' => $user->getId()],
            );

            $email = (new TemplatedEmail())
                ->from('contact@chargether.com')
                ->to($user->getEmail())
                ->subject('Inscription sur notre Site Chargether')
                ->htmlTemplate('emails/register.html.twig')
                ->context([
                    'user' => $user,
                    'link' => $signatureComponents->getSignedUrl(),
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Account Verified! You can now log in.');

            return $this->redirectToRoute('app_login');
        }

        return $this->renderForm('registration/register.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/verify/fail', name: 'app_verify_fail')]
    public function failVerify(Request $request): Response
    {
        return $this->render('registration/resend_verify_email.html.twig');
    }

    #[Route('/verify/resend', name: 'app_verify_resend_email')]
    public function resendVerifyEmail(Request $request, VerifyEmailHelperInterface $verifyEmailHelper, MailerInterface $mailer, UsersRepository $usersRepository): Response
    {
        $user = $usersRepository->findOneBy(['email' => $request->get('email')]);

        if ($request->getMethod() === 'POST') {
            $signatureComponents = $verifyEmailHelper->generateSignature(
                'app_verify_email',
                strval($user->getId()),
                $user->getEmail(),
                ['id' => $user->getId()],
            );

            $email = (new TemplatedEmail())
                ->from('contact@chargether.com')
                ->to($user->getEmail())
                ->subject('Inscription sur notre Site Chargether')
                ->htmlTemplate('emails/register.html.twig')
                ->context([
                    'user' => $user,
                    'link' => $signatureComponents->getSignedUrl(),
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Email send!');
        }
        return $this->redirectToRoute('app_login');
    }
}
