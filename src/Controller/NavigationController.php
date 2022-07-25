<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavigationController extends AbstractController
{
    #[Route('/navigate/{destination}', name: 'app_navigate_to', methods: ['GET'])]
    public function navigateTo(string $destination): Response
    {
        return $this->render('navigation/navigation.html.twig', [
            'googleApiKey' => $this->getParameter('google_api_key'),
            'destination' => $destination,
        ]);
    }
}
