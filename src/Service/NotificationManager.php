<?php

namespace App\Service;

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

    public function sendNotificationTo(UserInterface $destination, string $body): void
    {
        $notification = new Notification();
        $notification->setBody($body);
        $notification->setDestinationUser($destination);

        $this->notifRepository->add($notification, true);
    }
}
