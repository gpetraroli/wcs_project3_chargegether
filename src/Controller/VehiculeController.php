<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\VehiclesRepository;
use App\Service\VehicleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User|null getUser()
 */
class VehiculeController extends AbstractController
{
    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(VehicleManager $vehicleManager): Response
    {
        return $this->render('Vehicule/index.html.twig', [
            'selectedVehicleId' => $vehicleManager->getSelectedVehicle(),
        ]);
    }

    #[Route('/vehicules/ajouter', name: 'vehicle_add_view')]
    public function addVehiclesRender(VehiclesRepository $vehiclesRepository): Response
    {
        $vehicles = $vehiclesRepository->findAll();
        return $this->render('Vehicule/add.html.twig', [
            'vehicles' => $vehicles,
        ]);
    }

    #[Route('/add/vehicles/{id}', name: 'vehicle_add')]
    public function addVehicles(
        Vehicle $vehicle,
        EntityManagerInterface $entityManager,
        VehicleManager $vehicleManager
    ): Response {
        $user = $this->getUser();
        $user->addVehicle($vehicle);
        $entityManager->flush();

        $vehicleManager->selectDefaultVehicle($user->getVehicles());

        return $this->redirectToRoute('vehicules');
    }

    #[Route('/remove/vehicles/{id}', name: 'vehicle_remove')]
    public function remove(
        Vehicle $vehicle,
        EntityManagerInterface $entityManager,
        VehicleManager $vehicleManager
    ): Response {
        $user = $this->getUser();
        $user->removeVehicle($vehicle);
        $entityManager->flush();

        $vehicleManager->removeSelectedVehicle($vehicle->getId());
        $vehicleManager->selectDefaultVehicle($user->getVehicles());

        return $this->redirectToRoute('vehicules');
    }

    #[Route('/vehicules/select/{id}', name: 'app_select_vehicle', methods: ['GET'])]
    public function selectVehicle(int $id, VehicleManager $vehicleManager): Response
    {
        $vehicleManager->setSelectedVehicle($id);

        return $this->redirectToRoute('vehicules');
    }
}
