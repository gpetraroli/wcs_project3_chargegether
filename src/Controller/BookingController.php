<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Form\BookingType;
use App\Service\VehicleManager;
use App\Service\BookingPriceManager;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    private BookingPriceManager $bookingPriceManager;

    public function __construct(BookingPriceManager $bookingPriceManager)
    {
        $this->bookingPriceManager = $bookingPriceManager;
    }

    //Afficher list resa
    #[Route('/reservations', name: 'booking')]
    public function showBookingsList(Request $request, EntityManagerInterface $manager): Response
    {
        return $this->render('booking/index.html.twig');
    }

    #[Route('/api/price', name: 'api_price')]
    public function apiPrice(
        \DateTimeImmutable $dateBegin,
        \DateTimeImmutable $dateEnd,
        int $vehiclePower,
        int $stationPower
    ): JsonResponse {
        $price = $this->bookingPriceManager->calculateBookingPrice(
            $dateBegin,
            $dateEnd,
            $vehiclePower,
            $stationPower
        );

        return $this->json($price);
    }

    //nouvelle reservation
    #[Route('/hote/reserver/{id}', name: 'add_booking', methods: ['GET'])]
    public function addBooking(
        int $id,
        Station $station,
        Request $request,
        BookingsRepository $bookingsRepository,
        VehicleManager $vehicleManager
    ): Response {
        $booking = new Booking();
        $booking->setStation($station);
        $booking->setUser($this->getUser());

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setVehicle($form->get('vehicle')->getData());
            $booking->setStartRes($form->get('startRes')->getData());
            $booking->setEndRes($form->get('endRes')->getData());

            $price = $this->bookingPriceManager->calculateBookingPrice(
                $form->get('endRes')->getData(),
                $form->get('startRes')->getData(),
                $form->get('vehicle')->getData()->getBatteryPower(),
                $station->getPower()->value
            );
            $booking->setBookingPrice(strval($price));
            $bookingsRepository->add($booking, true);
            $this->addFlash('success', 'nouvelle résa effectuée');

            return $this->redirectToRoute('booking');
        }

        return $this->render('booking/addbooking.html.twig', [
            'form' => $form->createView(),
            'station' => $station,
            'selectVehicle' => $vehicleManager->getSelectedVehicle(),
        ]);
    }

    //recapitulatif infos resa
    #[Route('/reservation/{id}', name: 'infos_booking')]
    public function showBookingInfos(): Response
    {
        return $this->render('booking/infosbooking.html.twig');
    }

}
