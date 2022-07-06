<?php

namespace App\Controller;

use App\Repository\NotificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/api/notifications/new', name: 'api_notifications_new', methods: ['GET'])]
    public function getNewNotifications(NotificationsRepository $notifRepository): JsonResponse
    {
        $notifications = $notifRepository->findBy([
            'destinationUser' => $this->getUser(),
            'isRead' => false,
        ]);

        $notificationsData = [];
        foreach ($notifications as $notification) {
            $notificationsData[] = [
                'body' => $notification->getBody(),
                'createdAt' => $notification->getCreatedAt(),
            ];
        }
        return $this->json($notificationsData);
    }

    #[Route('/notifications', name: 'app_notifications', methods: ['GET'])]
    public function show(): Response
    {
        return $this->render('profil/notifications.html.twig');
    }
}
