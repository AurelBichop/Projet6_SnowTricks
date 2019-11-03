<?php

namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     * @param ObjectManager $manager
     * @return Response
     */
    public function index(ObjectManager $manager)
    {
        $nbUsers = $manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
        $nbTricks = $manager->createQuery('SELECT COUNT(t) FROM App\Entity\Trick t')->getSingleScalarResult();
        $nbComments = $manager->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')->getSingleScalarResult();

        return $this->render('admin/dashboard/index.html.twig', [
            'nbUsers'=>$nbUsers,
            'nbTricks'=>$nbTricks,
            'nbComments'=>$nbComments,
        ]);
    }
}
