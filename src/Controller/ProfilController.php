<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'app_profil_')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/infos', name: 'infos')]
    public function infos(): Response
    {
        return $this->render('profil/infos.html.twig');
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
