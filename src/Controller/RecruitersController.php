<?php

namespace App\Controller;

use App\Entity\JobAds;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
