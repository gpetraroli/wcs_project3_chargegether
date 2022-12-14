<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\StationReview;
use App\Entity\Vehicle;
use App\Form\BookingType;
use App\Form\RateStationsType;
use App\Repository\NotificationsRepository;
use App\Repository\ReviewsRepository;
use App\Service\BookingPriceManager;
use DateTimeImmutable;
use App\Entity\Booking;
use App\Entity\Station;
use App\Entity\User;
use App\Form\EmailTypeVerification;
use App\Service\VehicleManager;
use App\Service\StationManager;
use App\Repository\BookingsRepository;
use App\Service\NotificationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
        return $this->render('booking/index.html.twig');
    }

    #[Route('/api/price/{dateBegin}/{dateEnd}/{vehicle}/{station}', name: 'booking_api_price')]
    #[ParamConverter('dateBegin', options: ['format' => 'd-m-Y H:i'])]
    #[ParamConverter('dateEnd', options: ['format' => 'd-m-Y H:i'])]
    public function apiPrice(
        DateTimeImmutable $dateBegin,
        DateTimeImmutable $dateEnd,
        Vehicle $vehicle,
        Station $station,
    ): JsonResponse {

        $price = $this->bookingPriceManager->calculateBookingPrice(
            $dateBegin,
            $dateEnd,
            intval($vehicle->getBatteryPower()),
            $station->getPower()->value,
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
        NotificationManager $notifManager,
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

            $booking->setBookingPrice(strval($price['price'] + $price['fees']));
            $bookingsRepository->add($booking, true);
            $this->addFlash('success', 'R??servation effectu??e avec succes');

            $messageBody = $this->getUser()->getUserName() . ' a r??serv?? votre borne ?? l\'adresse ' .
                $station->getAddress() .
                ' pour le ' . $booking->getStartRes()->format('d/m/Y') . ' ?? ' . $booking->getStartRes()->format('H:i') . ' merci de valider la reservation en cliquant ici';
            $notifManager->sendNotificationTo($station->getOwner(), $messageBody, true, $booking);

            return $this->redirectToRoute('booking_index');
        }

        return $this->render('booking/addbooking.html.twig', [
            'form' => $form->createView(),
            'station' => $station,
            'selectVehicle' => $vehicleManager->getSelectedVehicle(),
        ]);
    }

    #[Route('/hote/confirmer/{notification}/{booking}', name: 'booking_confirmation')]
    public function confirmReservation(Notification $notification, Booking $booking, NotificationsRepository $notifRepository, NotificationManager $notificationManager, BookingsRepository $bookingsRepository): Response
    {
        // On modifie la premi??re notification qui demandait ?? l'h??te de confirmer la r??sa
        $body = str_replace(' merci de valider la reservation en cliquant ici', '', $notification->getBody());
        $notification->setNeedConfirmation(false);
        $notification->setBody($body);
        $notifRepository->add($notification, true);

        $this->addFlash('success', 'Vous venez de confirmer la r??servation.');

        // On pr??vient le client que sa r??sa est confirm??e
        $messageBodyClient =  'Votre r??servation ?? bien ??t?? confirm??e, retrouvez-l?? dans l\'onglet R??servations';
        $notificationManager->sendNotificationTo($booking->getBookingUser(), $messageBodyClient);

        // On passe le confirmed de booking ?? true
        $booking->setConfirmed(true);
        $bookingsRepository->add($booking, true);


        return $this->redirectToRoute('app_notifications');
    }

    #[Route('/reservation/{id}/start', name: 'booking_startloc')]
    public function startLocation(Booking $booking, BookingsRepository $bookingsRepository, NotificationManager $notifManager): Response
    {
        $date = new DateTimeImmutable();
        $booking->setStartLoc($date);
        $bookingsRepository->add($booking, true);

        $station = $booking->getStation();

        $this->addFlash('success', 'La location a bien d??marr??');

        $messageBody = $this->getUser()->getUserName() . ' a d??marr?? la location ?? l\'adresse ' . $station->getAddress() . ' le ' . $date->format('d/m/Y') . ' a ' . $date->format('H:i');
        $notifManager->sendNotificationTo($station->getOwner(), $messageBody);

        return $this->redirectToRoute('booking_index');
    }

    #[Route('/reservation/{id}/end', name: 'booking_endloc')]
    public function endLocation(Booking $booking, BookingsRepository $bookingsRepository, NotificationManager $notifManager, MailerInterface $mailer): Response
    {
        $date = new DateTimeImmutable();
        $booking->setEndLoc($date);
        $bookingsRepository->add($booking, true);

        $station = $booking->getStation();

        $this->addFlash('success', 'La location est bien termin??e');

        $messageBody = $this->getUser()->getUserName() . ' a termin?? la location ?? l\'adresse ' . $station->getAddress() . ' le ' . $date->format('d/m/Y') . ' a ' . $date->format('H:i');
        $notifManager->sendNotificationTo($station->getOwner(), $messageBody);

        $email = (new Email())
            ->from('contact@chargether.com')
            ->to($station->getOwner()->getEmail())
            ->subject('R??cap de la location de votre borne ! ')
            ->html($this->renderView('/emails/end_location.html.twig'));

        $mailer->send($email);


        return $this->redirectToRoute('booking_review', ['id' => $station->getId()]);
    }

    #[Route('/reservation/{id}/review', name: 'booking_review')]
    public function stationReview(Station $station, Request $request, ReviewsRepository $reviewsRepository): Response
    {
        $stationReview = new StationReview();
        $form = $this->createForm(RateStationsType::class, $stationReview);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stationReview->setId($station->getId());
            $stationReview->setRate($form->get('rate')->getData());
            $stationReview->setBody($form->get('body')->getData());
            $stationReview->setStation($station);
            $stationReview->setOwner($this->getUser());

            $reviewsRepository->add($stationReview, true);

            $this->addFlash('success', 'Merci pour votre avis, il a bien ??t?? pris en compte');
            return $this->redirectToRoute('booking_index');
        }


        return $this->render('booking/rateStation.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
