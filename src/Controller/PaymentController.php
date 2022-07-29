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
class PaymentController extends AbstractController
{
    #[Route('/payment', name: 'app_payment')]
    public function index(Request $request): Response
    {
        if (!$request->query->has('payment_intent')) {
            $stripe = new \Stripe\StripeClient('sk_test_51LQneoJgJtAYPeHHY9REurDYqU5jZqwJR1BQRMfbXNuWuoWY4aj1lJj3JRqXVYnhvDA0Wrc7Qcsv77xXIMMSYNJD000Kq9IkVO');
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => 1000,
                'currency' => 'eur',
                'payment_method_types' => ['card'],
            ]);
        }

        return $this->render('payment.html.twig', [
            'clientSecret' => $paymentIntent->client_secret ?? null,
        ]);
    }
}
