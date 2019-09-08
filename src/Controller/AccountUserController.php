<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\UserAccountType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountUserController extends AbstractController
{


    /**
     * Permet d'afficher et gerer le formulaire de connection
     *
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();

        return $this->render('account/login.html.twig',[
            'error' => $error !== null
        ]);
    }

    /**
     * Permet de se deconnecter
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {

    }

    /**
     * Permet d'afficher le formulaire et l'enregistrement d'un utilisateur
     *
     * @Route("/register", name="account_register")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function register(Request $request,ObjectManager $manager, UserPasswordEncoderInterface $encoder,Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));

            $manager->persist($user);
            $manager->flush();


            // Create a message ******

            $message = (new Swift_Message('Validation de votre inscription'))
                ->setFrom('aurel.bichop@laposte.net')
                ->setTo($user->getEmail())
                ->setBody(' Bonjour dans le but de confirmer votre compte merci de cliquer sur ce lien : http://127.0.0.1:8000/confirm/'.$user->getToken());

            $mailer->send($message);

            //************************


            $this->addFlash(
                'info',
                "Bonjour {$user->getFullname()} et bienvenue sur SnowTrick"
            );

            return $this->redirectToRoute('accueil');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * Permet de modifier les informations du profile utilisateur
     *
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Request $request,ObjectManager $manager){

        $user = $this->getUser();

        $form = $this->createForm(UserAccountType::class,$user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Les données du profil ont été enregistrées avec succès !"
            );
        }
        return $this->render('account/profile.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de confirmer un compte utilisateur
     *
     * @Route("/confirm/{token}", name="account_confirm")
     *
     * @return string
     */
    public function confirmUser(User $user,ObjectManager $manager){

        $user->setValid(1);

        $manager->persist($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Merci votre compte est validé !"
        );

        return $this->redirectToRoute('account_login');
    }

}
