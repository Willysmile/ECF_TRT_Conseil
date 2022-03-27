<?php

namespace App\Controller;

use App\Entity\JobAds;
use App\Form\RecruitersChangeInfosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecruitersController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/recruteurs', name: 'app_recruiters')]
    public function index(): Response
    {
        $user = $this->getUser();
        $jobAds = $this->entityManager->getRepository(JobAds::class)->findBy(['is_validated' => true, 'recruiters' => $user]);


        if ($user && !$user->getIsValidated()) {
            return $this->render('security/UnValidatedUser.html.twig', []);
        }


        return $this->render('recruiters/index.html.twig', [
            'controller_name' => 'RecruitersController',
            'jobAds' => $jobAds

        ]);
    }

    #[Route('/recruters/compte', name: 'app_recruiters_account')]
    public function index2(Request $request): Response
    {
        $user = $this->getUser();
        if ($user && !$user->getIsValidated()) {
            return $this->render('security/UnValidatedUser.html.twig', []);
        }
        $form = $this->createForm(RecruitersChangeInfosType::class, $user);

        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $notification = "Vos informations ont bien étés mises à jour.";
        }


        return $this->render('recruiters/account.html.twig', [
            'controller_name' => 'RecruitersAccountController',
            'form' => $form->createView(),
            'notification' => $notification,

        ]);
    }
}
