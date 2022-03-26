<?php

namespace App\Controller;

use App\Entity\Candidates;
use App\Entity\Recruiters;
use App\Entity\Consultants;
use App\Form\CandidatesRegistrationType;
use App\Form\ConsultantRegistrationType;
use App\Form\ConsultantsRegistrationType;
use App\Form\RecruitersRegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/inscription-candidats", name="app_registration_candidates")
     */
    public function registrationCandidates(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {

        $user = new Candidates();

        $form = $this->createForm(CandidatesRegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($user->getRoles());
            $hash = $encoder->hashPassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/candidates_registration.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/inscription-recruteurs", name="app_registration_recruiters")
     */
    public function registrationRecruiters(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {

        $user2 = new Recruiters();

        $form = $this->createForm(RecruitersRegistrationType::class, $user2);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user2->setRoles($user2->getRoles());
            $hash = $encoder->hashPassword($user2, $user2->getPassword());
            $user2->setPassword($hash);

            $manager->persist($user2);
            $manager->flush();
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/recruiters_registration.html.twig', ['form' => $form->createView()]);

    }
    /**
     * @Route("/inscription-consultants", name="app_registration_consultants")
     */
    public function registrationConsultants(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $encoder): Response
    {

        $user3 = new Consultants();

        $form = $this->createForm(ConsultantsRegistrationType::class, $user3);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user3->setRoles($user3->getRoles());
            $hash = $encoder->hashPassword($user3, $user3->getPassword());
            $user3->setPassword($hash);

            $manager->persist($user3);
            $manager->flush();
            return $this->redirectToRoute('admin');
        }

        return $this->render('security/consultant_registration.html.twig', ['form' => $form->createView()]);

    }
}
