<?php

namespace App\Controller;


use App\Entity\Trick;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{

    /**
     * Permet d'ajouter un nouveau trick
     *
     * @IsGranted("ROLE_USER")
     *
     * @Route("/trick/new", name="new_trick")
     *
     */
    public function create(Request $request,ObjectManager $manager)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class,$trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'info',
                "Le trick {$trick->getTitre()} a bien été ajouté"
            );

            return $this->redirectToRoute('accueil');
        }

        return $this->render('trick/new.html.twig', [
            'form' => $form->createView()
        ]);
    }



    /**
     * Permet de d'afficher la liste de tout les tricks
     *
     * @Route("/trick/all",name="all_trick")
     *
     * @param TrickRepository $repository
     * @return Response
     */
    public function index(TrickRepository $repository){

        return $this->render('trick/index.html.twig',[
            'tricks' => $repository->findAll()
        ]);
    }

    /**
     * Permet d'afficher un trick en lien avec son slug (param converter)
     * et enregistre les commentaires
     *
     * @Route("/trick/{slug}",name="show_trick")
     *
     */
    public function show(Trick $trick){

        return $this->render('trick/show.html.twig',[
            'trick' => $trick,
        ]);
    }

    /**
     * Permet la mise a jour d'un trick
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @Route("/trick/{slug}/edit", name="edit_trick")
     */
    public function edit(Trick $trick, Request $request, ObjectManager $manager){

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "La fiche <strong>{$trick->getTitre()}</strong> a bien été mise à jour !"
            );
            return $this->redirectToRoute('show_trick',[
                'slug'=>$trick->getSlug()
            ]);
        }

        return $this->render('trick/edit.html.twig',[
            'trick' => $trick,
            'form'  => $form->createView()
        ]);
    }

    /**
     * Permet la suppression d'un trick
     *
     * @Route("/trick/{slug}/delete", name="delete_trick")
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @return Response
     */
    public function delete(Trick $trick,ObjectManager $manager){

        $manager->remove($trick);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le trick {$trick->getTitre()} à bien été supprimé"
        );
        return $this->redirectToRoute('accueil');
    }
}
