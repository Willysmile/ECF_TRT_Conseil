<?php

namespace App\Controller;

use App\Entity\JobAds;
use App\Form\JobAdsAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobAdsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recruteurs/annonces', name: 'app_jobAd')]
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $jobAd = new JobAds();
        $form = $this->createForm(JobAdsAddType::class, $jobAd);
        $notification = null;
        $form->handleRequest($request);
        $jobAd->setRecruiters($this->getUser());
        if ($user && !$user->getIsValidated()) {
            return $this->render('security/UnValidatedUser.html.twig', []);
        }

        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($jobAd);
            $this->entityManager->flush();
            $notification = "Votre annonce a été enregistrée, elle sera visible une fois validée par nos consultants.";
            unset($form);
            unset($jobAd);
            $jobAd = new JobAds();
            $form = $this->createForm(JobAdsAddType::class, $jobAd);


        }


        return $this->render('recruiters/jobAd/AddJobAd.html.twig', [
            'controller_name' => 'JobAddController', 'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
