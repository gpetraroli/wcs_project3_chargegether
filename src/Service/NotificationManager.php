<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationsRepository;

class NotificationManager
{
    private NotificationsRepository $notifRepository;

    public function __construct(NotificationsRepository $notifRepository)
    {
        $this->notifRepository = $notifRepository;
    }

    public function sendNotificationTo(User $destination, string $body): void
    {
        $notification = new Notification();
        $notification->setBody($body);
        $notification->setDestinationUser($destination);

        $this->notifRepository->add($notification, true);
    }
}
