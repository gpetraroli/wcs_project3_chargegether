<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\VehiclesRepository;
use App\Service\VehicleManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function Symfony\Component\Translation\t;

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
    public function addVehicles(Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if ($user->getVehicles()->count() < 2) {
            $user->addVehicle($vehicle);
            $entityManager->flush();
        } else {
            $this->addFlash(
                'danger',
                '2 véhicules maximum possibles'
            );
        }

        return $this->redirectToRoute('vehicules');
    }

    #[Route('/remove/vehicles/{id}', name: 'vehicle_remove')]
    public function remove(Vehicle $vehicle, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user->removeVehicle($vehicle);
        $entityManager->flush();

        return $this->redirectToRoute('vehicules');
    }

    #[Route('/vehicules/select/{id}', name: 'app_select_vehicle', methods: ['GET'])]
    public function selectVehicle(int $id, VehicleManager $vehicleManager): Response
    {
        $vehicleManager->setSelectedVehicle($id);

        return $this->redirectToRoute('vehicules');
    }
}
