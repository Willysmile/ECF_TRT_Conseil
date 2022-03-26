<?php

namespace App\Controller;

use App\Entity\JobAds;
use App\Entity\Recruiters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CandidatesController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidats', name: 'app_candidates')]
    public function index(): Response
    {
        $jobAds = $this->entityManager->getRepository(JobAds::class)->findBy(['is_validated' => true]);


        $user = $this->getUser();

        if ($user && !$user->getIsValidated()) {
            return $this->render('security/UnValidatedUser.html.twig', []);
        }

        return $this->render('candidates/index.html.twig', [
            'controller_name' => 'CandidatesController',
            'jobAds' => $jobAds
        ]);


    }
}
