<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @return Response
     */
    public function register(Request $request,ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user->setPassword($encoder->encodePassword($user,$user->getPassword()));

            $manager->persist($user);
            $manager->flush();

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

}
