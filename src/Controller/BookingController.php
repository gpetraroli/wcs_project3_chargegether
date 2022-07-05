<?php

namespace App\Controller;

use App\Entity\Booking;
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
        $booking = new Booking();

        return $this->render('booking/index.html.twig');
    }

    //nouvelle reservation
    #[Route('/reservation/new', name: 'add_booking')]
    public function addBooking(): Response
    {
        return $this->render('booking/addbooking.html.twig');
    }

    //recapitulatif infos resa
    #[Route('/reservation/{id}', name: 'infos_booking')]
    public function showBookingInfos(): Response
    {
        return $this->render('booking/infosbooking.html.twig');
    }
}
