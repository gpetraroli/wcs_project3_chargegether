<?php

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/infos', name: 'infos', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function infos(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(ProfileType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Les Informations de votre Compte ont bien été mises à jour.');

            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('profil/infos.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier-mdp', name: 'edit_password')]
    public function editPassword(): Response
    {
        return $this->render('profil/edit_password.html.twig');
    }

    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(): Response
    {
        return $this->render('profil/vehicules.html.twig');
    }
}
