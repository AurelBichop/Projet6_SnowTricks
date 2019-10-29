<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Form\UserAccountType;
use App\Repository\UserRepository;
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
     * @param AuthenticationUtils $utils
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

            // Create a message an send email ***************************************************

            $message = (new Swift_Message('Validation de votre inscription'))
                ->setFrom('aurel.bichop@laposte.net')
                ->setTo($user->getEmail())
                ->setBody(' Bonjour dans le but de confirmer votre compte merci de cliquer sur ce lien : http://127.0.0.1:8000/confirm/?token='.$user->getToken());

            $mailer->send($message);

            //*********************************************************************

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
     * @Route("/confirm", name="account_confirm")
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ObjectManager $manager
     * @return string
     */
    public function confirmUser(Request $request, UserRepository $userRepository, ObjectManager $manager){

        $token = $request->query->get('token');

        $user = $userRepository->findOneBy(['token'=>$token]);

        if($user !== null && $user->getValid() === 0){

            $user->setValid(1);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "Merci votre compte est validé !"
            );

        }else{
            $this->addFlash(
                'danger',
                "Compte déja validé ou inexistant"
            );
        }

        return $this->redirectToRoute('account_login');
    }

    /**
     * Permet de rénitialiser son mot de passe en cas d'oublie
     *
     * @Route("/forgotpass", name="forgot_password")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param Swift_Mailer $mailer
     * @return Response
     */
    public function forgotPassword(Request $request, UserRepository $userRepository, Swift_Mailer $mailer){

        if (!empty($request->get('email'))){
            $email = $request->get('email');
            $user = $userRepository->findOneBy(['email'=>$email]);

            if($user !== null){

                $message = (new Swift_Message('Rénitialisation de mot de passe'))
                    ->setFrom('aurel.bichop@laposte.net')
                    ->setTo($user->getEmail())
                    ->setBody(' Pour rénitialiser votre mot de passe merci de cliquer sur ce lien : http://127.0.0.1:8000/userpassword/reset/?token='.$user->getToken());

                $mailer->send($message);

                $this->addFlash(
                    'info',
                    "Un courriel vous a été envoyé !"
                );
            }else{
                $this->addFlash(
                    'danger',
                    "Email invalide!"
                );
            }
        }

        return $this->render('account/forgot_pass.html.twig');
    }


    /**
     * Permet de renitialiser un mot de passe oublié
     *
     * @Route("/userpassword/reset", name="password_reset")
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return string
     */
    public function resetPassword(Request $request, UserRepository $userRepository, ObjectManager $manager,UserPasswordEncoderInterface $encoder){

        $token = $request->query->get('token');
        $user = $userRepository->findOneBy(['token'=>$token]);

        if($user !== null){
            $resetPassword = new ResetPassword();

            $form = $this->createForm(ResetPasswordType::class,$resetPassword);

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $newPassword = $resetPassword->getNewPassword();
                $newPasswordHash = $encoder->encodePassword($user,$newPassword);

                $user->setPassword($newPasswordHash);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Mot de passe modifié merci de vous connecter avec ce dernier !"
                );
                return $this->redirectToRoute('account_login');
            }

            return $this->render('account/reset_pass.html.twig',[
                'form'=>$form->createView()
            ]);
        }

        return $this->redirectToRoute('accueil');
    }
}
