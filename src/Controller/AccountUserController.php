<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AccountUserController extends AbstractController
{


    /**
     * Permet d'afficher et gerer le formulaire de connection
     *
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login()
    {

        return $this->render('account/login.html.twig',[
            'hasError' => 'error'
        ]);
    }

    /**
     * Permet l'enregistrement d'un utilisateur
     *
     * @Route("/register", name="account_register")
     *
     * @return Response
     */
    public function register()
    {
        return $this->render('account/register.html.twig', [
            'controller_name' => 'AccountUserController',
        ]);
    }

}
