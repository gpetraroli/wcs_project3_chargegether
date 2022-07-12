<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionUserController extends AbstractController
{
    #[Route('/question/user', name: 'app_question_user')]
    public function index(): Response
    {
        return $this->render('question_user/index.html.twig', [
            'controller_name' => 'QuestionUserController',
        ]);
    }
}
