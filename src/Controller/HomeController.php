<?php

namespace App\Controller;

use App\Service\VehicleManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(VehicleManager $vehicleManager): Response
    {
        return $this->render('home/index.html.twig', [
            'googleApiKey' => $this->getParameter('google_api_key'),
            'selectedVehicleId' => $vehicleManager->getSelectedVehicle(),
        ]);
    }
}
