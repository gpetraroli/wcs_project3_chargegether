<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Notification;
use App\Repository\NotificationsRepository;
use Symfony\Component\Security\Core\User\UserInterface;

class NotificationManager
{
    private NotificationsRepository $notifRepository;

    public function __construct(NotificationsRepository $notifRepository)
    {
        $this->notifRepository = $notifRepository;
    }

    public function sendNotificationTo(
        UserInterface $destination, string $body, bool $needConfirmation = false, ?Booking $booking = null): void {
        $notification = new Notification();
        $notification->setBody($body);
        $notification->setDestinationUser($destination);
        $notification->setNeedConfirmation($needConfirmation);
        $notification->setBooking($booking);

        $this->notifRepository->add($notification, true);
    }
}
