<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use App\Repository\NotificationsRepository;

class NotificationManager
{
    public function sendNotificationTo(User $destination, string $body, NotificationsRepository $notifRepository): void
    {
        $notification = new Notification();
        $notification->setBody($body);
        $notification->setDestinationUser($destination);

        $notifRepository->add($notification, true);
    }
}
