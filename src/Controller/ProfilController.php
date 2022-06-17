<?php

namespace App\Controller;

use App\Config\PlugType;
use App\Config\StationPower;
use App\Entity\Station;
use App\Form\StationType;
use App\Repository\StationsRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function hoteInscription(Request $request, StationsRepository $stationsRepository): Response
    {
        $station = new Station();

        $form = $this->createForm(StationType::class, $station);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $station = $form->getData();
            $station->setOwner($this->getUser());

            $stationsRepository->add($station, true);

            return $this->redirectToRoute('app_profil_hote');
        }

        return $this->renderForm('profil/hote_inscription.html.twig', [
            'form' => $form,
            'plugsType' => PlugType::cases(),
            'stationPowers' => StationPower::cases(),
            ]);
    }

    #[Route('/hote', name: 'hote')]
    public function hote(): Response
    {
        return $this->render('profil/hote.html.twig');
    }
}
