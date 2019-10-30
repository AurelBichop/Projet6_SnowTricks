<?php

namespace App\Controller;


use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
            'tricks' => $trickRepository->findBy([],['id'=>'DESC'],10),
            'nbTricks'=>$manager->createQuery('SELECT COUNT(t) FROM App\Entity\Trick t')->getSingleScalarResult()
        ]);
    }

    /**
     * @Route("/accueil/more",name="more_tricks")
     * @param TrickRepository $trickRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function loadMore(TrickRepository $trickRepository, Request $request){

        $depart = (int)$request->get('nbCard');
        $nbEnplus = 10;

        //Pour tester dans des conditions Web
        //sleep(5);

        $listeMoreTrick = $trickRepository->findBy(
            [],
            ['id'=>'DESC'],
            $limit = $nbEnplus,
            $offset = $depart
        );

        $datas = [];
        foreach ( $listeMoreTrick as $key => $item) {
            $datas[$key]['titre'] = $item->getTitre();
            $datas[$key]['slug'] = $item->getSlug();
            $datas[$key]['author'] = $item->getAuthor()->getFullname();
            $datas[$key]['coverImage'] = $item->getCoverImage();
            $datas[$key]['id'] = $item->getId();
        }

        return new JsonResponse($datas);

    }
}
