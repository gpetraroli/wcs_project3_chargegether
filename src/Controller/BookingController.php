<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Station;
use App\Form\BookingType;
use App\Repository\BookingsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    //Afficher list resa
    #[Route('/reservations', name: 'booking')]
    public function showBookingsList(Request $request, EntityManagerInterface $manager): Response
    {
        return $this->render('booking/index.html.twig');
    }

    //nouvelle reservation
    #[Route('/hote/reserver/{id}', name: 'add_booking')]
    public function addBooking(Station $station, Request $request, BookingsRepository $bookingsRepository): Response
    {
        $fees = 1;
        $coefficient = 2.5;
        $electricityPrice = 0.3;

        $booking = New Booking();
        $booking->setStation($station);
        $booking->setUser($this->getUser());

        $form = $this->createForm(BookingType::class , $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $booking->setVehicle($form->get('vehicle')->getData());
            $booking->setStartRes($form->get('startRes')->getData());
            $booking->setEndRes($form->get('endRes')->getData());
            // calcul du prix de la réservation
            $interval = $form->get('endRes')->getData()->diff($form->get('startRes')->getData());
            $intervarInHours = $interval->format('%h') + $interval->format('%i')/60;
            $vehiclePower = $form->get('vehicle')->getData()->getBatteryPower();
            $stationPower = $station->getPower()->value;
            $power = ($vehiclePower < $stationPower) ? $vehiclePower : $stationPower;
            $price = $electricityPrice * $coefficient * $intervarInHours * $power + $fees;

            $booking->setBookingPrice(strval($price));
            $bookingsRepository->add($booking, true);
            $this->addFlash('success', 'nouvelle résa effectuée');

            return $this->redirectToRoute('booking');

        }



        return $this->render('booking/addbooking.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //recapitulatif infos resa
    #[Route('/reservation/{id}', name: 'infos_booking')]
    public function showBookingInfos(): Response
    {
        return $this->render('booking/infosbooking.html.twig');
    }
}
