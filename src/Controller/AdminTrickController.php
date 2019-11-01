<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Service\Pagination;
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
}
