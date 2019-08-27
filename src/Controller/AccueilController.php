<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
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


    //**************************************************/
    /**
     * Pour tester l'ajout d'un trick
     * @Route("/ajout")
     */
    public function addTrick(ObjectManager $manager){

        $trick = new Trick();

        $trick->setTitre('Figure de con fiture')
                ->setDescription('un super trick a la noix de cajou et aux cahuette')
                ->setVariety('group2');

        $manager->persist($trick);
        $manager->flush();

        return $this->redirectToRoute('accueil');
    }
}
