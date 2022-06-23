<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil', name: 'app_profil_')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/infos', name: 'edit_profil', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        UsersRepository $usersRepository,
        EntityManagerInterface $manager,
    ): Response {
        $form = $this->createForm(RegistrationFormType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $usersRepository->add($this->getUser(), true);
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Profil mis à jour avec succès !'
            );

            return $this->redirectToRoute('profil');
        }

        return $this->renderForm('profil/infos.html.twig', [
            'user' => $this->getUser(),
            'form' => $form,
        ]);
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/modifier-mdp', name: 'edit_password', methods: ['GET', 'POST'])]
    public function editPassword(
        User $user,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher
    ): Response {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->get('oldPassword')->getData())) {
                $user->setPassword(
                    $hasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $manager->persist($user);
                $manager->flush();

                $this->addFlash('success', 'Votre mot de passe à bien été changé !');
                return $this->redirectToRoute('profile');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('profil/infos.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }


    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(): Response
    {
        return $this->render('profil/vehicules.html.twig');
    }

    #[Route('/hote-inscription', name: 'hote_inscription')]
    public function hoteInscription(): Response
    {
        return $this->render('profil/hote_inscription.html.twig');
    }

    #[Route('/hote', name: 'hote')]
    public function hote(): Response
    {
        return $this->render('profil/hote.html.twig');
    }
}
