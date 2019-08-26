<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * Page d'acceuil, récupere les tricks
     *
     * @Route("/", name="accueil")
     */
    public function index(TrickRepository $trickRepository)
    {

        return $this->render('accueil.html.twig', [
            'tricks' => $trickRepository->findAll()
        ]);
    }
}
