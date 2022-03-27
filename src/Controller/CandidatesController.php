<?php

namespace App\Controller;

use App\Entity\JobAds;
use App\Entity\Recruiters;
use App\Form\CandidatesChangeInfosType;
use App\Form\CandidatesChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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
    #[Route('/candidats/compte', name: 'app_candidates_account')]
    public function index2(Request $request, SluggerInterface $slugger): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(CandidatesChangeInfosType::class, $user);
        $notification = null;
        $form->handleRequest($request);
        $CvFile = $form->get('CvFilename')->getData();
        if ($form->isSubmitted() && $form->isValid()) {

            if ($CvFile) {
                $originalFilename = pathinfo($CvFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $CvFile->guessExtension();

                try {
                    $CvFile->move(
                        $this->getParameter('cv_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {

                }

                $user->setCvFilename($newFilename);
                $this->entityManager->flush();
                $notification = "Vos informations ont bien étés mises à jour.";
            }
        }
        return $this->render('candidates/account.html.twig', [
            'controller_name' => 'CandidatesAccountController', 'form' => $form->createView(), 'notification' => $notification, "fileExist" => $CvFile
        ]);

    }

    #[Route('/candidats/compte/password', name: 'app_candidates_password')]
    public function index3(Request $request, UserPasswordHasherInterface $encoder): Response
    {

        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(CandidatesChangePasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_pwd = $form->get('old_password')->getData();
            if ($encoder->isPasswordValid($user, $old_pwd)) {
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);
                $user->setPassword($password);


                $this->entityManager->flush();
                $notification = "Votre nouveau mot de passe à bien été mis à jour.";
            } else {
                $notification = "Votre mot de passe actuel n’est pas le bon.";
            }

        }
        return $this->render('candidates/password.html.twig', [
            'controller_name' => 'CandidatesAccountController','form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
