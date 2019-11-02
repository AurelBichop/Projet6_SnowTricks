<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     *
     * @param Pagination $pagination
     * @param $page
     * @return Response
     */
    public function index(Pagination $pagination, $page)
    {

        $pagination->setEntityClass(Comment::class)
            ->setPage($page)
            ->setLimit(20);

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Permet de supprimer un Commentaire
     *
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete")
     *
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Comment $comment, ObjectManager $manager){
        $manager->remove($comment);
        $manager->flush();

        $this->addFlash(
            'success',
            "Commentaire supprimé"
        );

        return $this->redirectToRoute('admin_comments_index');
    }
}
