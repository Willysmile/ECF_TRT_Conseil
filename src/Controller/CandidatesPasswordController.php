<?php

namespace App\Controller;

use App\Form\CandidatesChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class CandidatesPasswordController extends AbstractController
{   private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/candidats/compte/password', name: 'app_candidates_password')]
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
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
