<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminTrickController extends AbstractController
{
    /**
     * @Route("/admin/tricks/{page<\d+>?1}", name="admin_tricks_index")
     *
     * @param Pagination $pagination
     * @param $page
     * @return Response
     */
    public function index(Pagination $pagination, $page)
    {

        $pagination->setEntityClass(Trick::class)
            ->setPage($page)
            ->setLimit(20);

        return $this->render('admin/trick/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de supprimer une annonce
     *
     * @Route("/admin/tricks/{id}/delete", name="admin_tricks_delete")
     *
     * @param Trick $trick
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Trick $trick, ObjectManager $manager){
        $manager->remove($trick);
        $manager->flush();

        $this->addFlash(
            'success',
            "Trick supprimé"
        );

        return $this->redirectToRoute('admin_tricks_index');
    }
}
