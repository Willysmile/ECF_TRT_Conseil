<?php

namespace App\Controller;

use App\Form\CandidatesChangeInfosType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CandidatesAccountController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/candidats/compte', name: 'app_candidates_account')]
    public function index(Request $request, SluggerInterface $slugger): Response
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
}


