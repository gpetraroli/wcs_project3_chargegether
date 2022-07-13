<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Booking;
use App\Entity\Station;
use App\Entity\User;
use App\Form\BookingType;
use App\Service\VehicleManager;
use App\Service\BookingPriceManager;
use App\Repository\BookingsRepository;
use App\Service\NotificationManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @method User|null getUser()
 */
class BookingController extends AbstractController
{
    private BookingPriceManager $bookingPriceManager;

    public function __construct(BookingPriceManager $bookingPriceManager)
    {
        $this->bookingPriceManager = $bookingPriceManager;
    }

    #[Route('/reservations', name: 'booking_index')]
    public function showBookingsList(): Response
    {
        $bookings = $this->getUser()->getBookings();
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings
        ]);
    }

    #[Route('/api/price', name: 'booking_api_price')]
    public function apiPrice(
        DateTimeImmutable $dateBegin,
        DateTimeImmutable $dateEnd,
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
    #[Route('/hote/reserver/{id}', name: 'booking_new')]
    public function addBooking(
        Station $station,
        Request $request,
        BookingsRepository $bookingsRepository,
        VehicleManager $vehicleManager,
        NotificationManager $notifManager
    ): Response {
        $booking = new Booking();
        $booking->setStation($station);
        $booking->setBookingUser($this->getUser());

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
            $this->addFlash('success', 'Réservation effectuée avec succes');

            $messageBody = $this->getUser()->getUserName() . 'a réservé votre station à l\'adresse ' .
                $station->getAddress() .
                ' pour le ' . $booking->getStartRes()->format('d/m/Y') . ' à ' . $booking->getStartRes()->format('H:i');
            $notifManager->sendNotificationTo($station->getOwner(), $messageBody);

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/addbooking.html.twig', [
            'form' => $form->createView(),
            'station' => $station,
            'selectVehicle' => $vehicleManager->getSelectedVehicle(),
        ]);
    }

    #[Route('/reservation/{id}', name: 'booking_info')]
    public function showBookingInfos(): Response
    {
        return $this->render('booking/infosbooking.html.twig');
    }

    #[Route('/reservation/{id}/start', name: 'booking_startloc')]
    public function startLocation(Booking $booking, BookingsRepository $bookingsRepository, NotificationManager $notifManager): Response
    {
        $date = new DateTimeImmutable();
        $booking->setStartLoc($date);
        $bookingsRepository->add($booking, true);

        $station = $booking->getStation();

        $this->addFlash('success', 'La location a bien démarré');

        $messageBody = $this->getUser()->getUserName() . ' a démarré la location à l\'adresse ' . $station->getAddress() . ' le ' . $date->format('d/m/Y') . ' a ' . $date->format('H:i');
        $notifManager->sendNotificationTo($station->getOwner(), $messageBody);

        return $this->redirectToRoute('booking_index');
    }

    #[Route('/reservation/{id}/end', name: 'booking_endloc')]
    public function endLocation(Booking $booking, BookingsRepository $bookingsRepository, NotificationManager $notifManager): Response
    {
        $date = new DateTimeImmutable();
        $booking->setEndLoc($date);
        $bookingsRepository->add($booking, true);

        $station = $booking->getStation();

        $this->addFlash('success', 'La location est bien terminée');

        $messageBody = $this->getUser()->getUserName() . ' a terminé la location à l\'adresse ' . $station->getAddress() . ' le ' . $date->format('d/m/Y') . ' a ' . $date->format('H:i');
        $notifManager->sendNotificationTo($station->getOwner(), $messageBody);


        return $this->redirectToRoute('booking_index');
    }
}
