<?php

namespace App\Controller;


use App\Form\RecruitersChangeInfosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecruitersAccountController extends AbstractController
{private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/recruters/compte', name: 'app_recruiters_account')]

    public function index(Request $request): Response
    {
        $user = $this->getUser();
        if ($user && !$user->getIsValidated()) {
            return $this->render('security/UnValidatedUser.html.twig', []);
        }
        $form = $this->createForm(RecruitersChangeInfosType::class, $user);

        $notification = null;
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

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
