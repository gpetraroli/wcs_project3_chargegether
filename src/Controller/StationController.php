<?php

namespace App\Controller;

use App\Config\PlugType;
use App\Config\StationPower;
use App\Entity\Station;
use App\Entity\User;
use App\Form\StationType;
use App\Repository\StationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @method User|null getUser()
 */
class StationController extends AbstractController
{
    #[Route('/hote/inscription', name: 'app_hote_inscription')]
    public function hoteInscription(Request $request, StationsRepository $stationsRepository): Response
    {
        $station = new Station();
        $station->setOwner($this->getUser());

        $form = $this->createForm(StationType::class, $station);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stationsRepository->add($station, true);

            $this->addFlash('success', 'hôte correctement ajouté');

            return $this->redirectToRoute('app_hotes');
        }

        return $this->renderForm('profil/hote_inscription.html.twig', [
            'form' => $form,
            'plugsType' => PlugType::cases(),
            'stationPowers' => StationPower::cases(),
            'googleApiKey' => $this->getParameter('google_api_key'),
        ]);
    }

    #[Route('/hotes', name: 'app_hotes')]
    public function hote(): Response
    {
        return $this->render('profil/hote.html.twig');
    }

    #[Route('/hote/delete/{id}', name: 'app_hotes_delete')]
    public function delete(int $id, StationsRepository $stationsRepository): Response
    {
        $station = $stationsRepository->findOneBy(['id' => $id]);
        $stationsRepository->remove($station, true);

        return $this->redirectToRoute('app_profil_index');
    }

    #[Route('/api/hotes', name: 'api_hotes')]
    public function stationsApi(StationsRepository $stationsRepository): JsonResponse
    {
        $stations = $stationsRepository->findAll();

        $stationsData = [];

        foreach ($stations as $station) {
            $coords = explode(',', $station->getCoordinates());
            $stationsData[] = [
                'id' => $station->getId(),
                'type' => $station->getPlugType(),
                'power' => $station->getPower(),
                'lat' => floatval($coords[0]),
                'lng' => floatval($coords[1]),
                'owner' => $station->getOwner()->getUserName(),
            ];
        }
        return $this->json($stationsData);
    }

    #[Route('/hote/edit/{id}', name: 'app_hote_edit')]
    public function edit(
        int $id,
        StationsRepository $stationsRepository,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $station = $stationsRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(StationType::class, $station);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'hôte correctement modifiè');
            return $this->redirectToRoute('app_hotes');
        }

        return $this->renderForm('profil/hote_inscription.html.twig', [
            'form' => $form,
            'plugsType' => PlugType::cases(),
            'stationPowers' => StationPower::cases(),
            'googleApiKey' => $this->getParameter('google_api_key'),
        ]);
    }
}
