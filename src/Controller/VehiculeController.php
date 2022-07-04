<?php

namespace App\Controller;

use App\Repository\VehiclesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(): Response
    {
        return $this->render('Vehicule/index.html.twig');
    }

    #[Route('/vehicules/ajouter', name: 'vehicle_add_view')]
    public function addVehiclesRender(VehiclesRepository $vehiclesRepository): Response
    {
        $vehicles = $vehiclesRepository->findAll();
        return $this->render('Vehicule/add.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/add/vehicles', name: 'vehicle_add')]
    public function addVehicles(): Response
    {

        return $this->render('Vehicule/add.html.twig');
    }
}
