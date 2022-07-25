<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationsRepository;
use Doctrine\Persistence\ManagerRegistry;
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
    public function showAll(): Response
    {
        return $this->render('profil/notifications.html.twig');
    }

    #[Route('/notification/{id}', name: 'app_notification_show', methods: ['GET'])]
    public function showOne(int $id, ManagerRegistry $managerRegistry): Response
    {
        $notification = $managerRegistry->getRepository(Notification::class)->findOneBy(['id' => $id]);
        $notification->setIsRead(true);
        $managerRegistry->getManager()->flush();

        return $this->render('/profil/notification.html.twig', [
            'notification' => $notification,
        ]);
    }

    #[Route('/notification/{id}/delete', name: 'app_notifications_delete')]
    public function delete(Notification $notification, NotificationsRepository $notifRepository): Response
    {
        if ($this->getUser() === $notification->getDestinationUser()) {
            $notifRepository->remove($notification, true);
            $this->addFlash('success', 'La notification a bien été supprimée !');
            return $this->redirectToRoute('app_notifications');
        }
        return $this->redirectToRoute('app_notifications');
    }
}
