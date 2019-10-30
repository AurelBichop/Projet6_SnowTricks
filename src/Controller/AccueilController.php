<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * Page d'acceuil, récupere les tricks
     *
     * @Route("/", name="accueil")
     * @param TrickRepository $trickRepository
     * @param ObjectManager $manager
     * @return Response
     */
    public function index(TrickRepository $trickRepository ,ObjectManager $manager)
    {

        return $this->render('accueil.html.twig', [

            'tricks' => $trickRepository->findBy(
                array(),
                array('id'=>'DESC'),
                10
            ),
            
        ]);
    }


    //**************************************************/

    /**
     * Pour tester l'ajout d'un trick
     * @Route("/ajout")
     * @param ObjectManager $manager
     * @return RedirectResponse
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
