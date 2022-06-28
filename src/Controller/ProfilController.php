<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Station;
use App\Config\PlugType;
use App\Form\ProfileType;
use App\Form\StationType;
use App\Config\StationPower;
use App\Form\UserPasswordType;
use App\Repository\UsersRepository;
use App\Repository\StationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/profil', name: 'app_profil_')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    #[Route('/infos', name: 'infos', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function infos(
        Request $request,
        EntityManagerInterface $manager,
    ): Response {
        $form = $this->createForm(ProfileType::class, $this->getUser());

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('success', 'Les Informations de votre Compte ont bien été mises à jour.');


            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('profil/infos.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/modifier-mdp', name: 'edit_password', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function editPassword(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $manager,
        UsersRepository $usersRepository
    ): Response {

        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(UserPasswordType::class);

        // je lui passe la requete
        $form->handleRequest($request);
        //si le formulaire a été soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $datas = $form->getData();

            $user->setUpdatedAt(new \DateTime());

            $newHashedPassword = $hasher->hashPassword($user, $datas['newPassword']);

            $user->setPassword($newHashedPassword);

            $manager->flush();

            $this->addFlash(
                'success',
                'Le Mot de Passe a été modifié .'
            );

            return $this->redirectToRoute('app_profil_index');
        }

        return $this->render('profil/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/vehicules', name: 'vehicules')]
    public function vehicules(): Response
    {
        return $this->render('profil/vehicules.html.twig');
    }

    #[Route('/hote-inscription', name: 'hote_inscription')]
    public function hoteInscription(Request $request, StationsRepository $stationsRepository): Response
    {
        $station = new Station();
        $station->setOwner($this->getUser());

        $form = $this->createForm(StationType::class, $station);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stationsRepository->add($station, true);

            $this->addFlash('success', 'hôte correctement ajouté');

            return $this->redirectToRoute('app_profil_hote');
        }

        return $this->renderForm('profil/hote_inscription.html.twig', [
            'form' => $form,
            'plugsType' => PlugType::cases(),
            'stationPowers' => StationPower::cases(),
        ]);
    }

    #[Route('/hote', name: 'hote')]
    public function hote(): Response
    {
        return $this->render('profil/hote.html.twig');
    }
}
