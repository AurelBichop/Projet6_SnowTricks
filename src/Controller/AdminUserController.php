<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Pagination;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * Liste et pagine l'ensemble des utilisateurs
     *
     * @Route("/admin/users/{page<\d+>?1}", name="admin_users_index")
     *
     * @param Pagination $pagination
     * @param $page
     * @return Response
     */
    public function index(Pagination $pagination, $page)
    {

        $pagination->setEntityClass(User::class)
            ->setPage($page)
            ->setLimit(20);

        return $this->render('admin/user/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route ("/admin/users/delunvalid", name="admin_users_delete_unvalid")
     * @param UserRepository $userRepository
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function delUserUnvalid(UserRepository $userRepository, ObjectManager $manager){

        //je recupere tout les comptes utilisateurs non confirmé
        $usersUnvalid = $userRepository->findBy(['valid'=>0]);

        //Suppressions des utilisateurs avec un compte non confirmé
        foreach ($usersUnvalid as $oneUserUnvalid){
            $manager->remove($oneUserUnvalid);
        }
        $manager->flush();

        $this->addFlash(
            'success',
            "Utilisateurs non valide supprimé"
        );

        return $this->redirectToRoute('admin_users_index');
    }

    /**
     * Permet de supprimer un Utilisateur
     *
     * @Route("/admin/users/{id}/delete", name="admin_users_delete")
     *
     * @param User $user
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(User $user, ObjectManager $manager){


        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            "Utilisateur supprimé"
        );

        return $this->redirectToRoute('admin_users_index');
    }
}
