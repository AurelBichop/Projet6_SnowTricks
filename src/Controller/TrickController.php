<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\FileUploader;
use App\Service\Pagination;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param Request $request
     * @param ObjectManager $manager
     * @param FileUploader $fileUploader
     * @return RedirectResponse|Response
     */
    public function create(Request $request,ObjectManager $manager, FileUploader $fileUploader)
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class,$trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //recupere le fichier de la request
            $coverImage = $form['coverImage']->getData();

            if($coverImage)
            {
                $coverImage = $fileUploader->upload($coverImage);
                $trick->setCoverImage($coverImage);
            }

            $trick->setAuthor($this->getUser());

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
     * @Route("/trick/all/{page<\d+>?1}",name="all_trick")
     *
     * @param $page
     * @param Pagination $pagination
     *
     * @return Response
     */
    public function index($page, Pagination $pagination){

        $pagination->setEntityClass(Trick::class)
            ->setPage($page)
            ->setLimit(20);

        return $this->render('trick/index.html.twig',[
                'pagination' => $pagination

        ]);
    }

    /**
     * @Route("/trick/more",name="more_tricks")
     * @param TrickRepository $trickRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function loadMore(TrickRepository $trickRepository, Request $request){

        $depart = (int)$request->get('nbCard');
        $nbEnplus = 10;

        //sleep(5);

        $listeMoreTrick = $trickRepository->findBy(
            array(),
            array('id'=>'DESC'),
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

    /**
     * Pour la supression d'une image de trick
     *
     * @Security("is_granted('ROLE_USER') and user === image.getTrick().getAuthor()")
     *
     * @Route("/trick/image/{id}/delete",name="delete_image")
     * @param Image $image
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function deleteImage(Image $image, ObjectManager $manager){

        unlink('uploads/images/'.$image->getUrl());

        $manager->remove($image);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'image à bien été supprimé"
        );
        return $this->redirectToRoute('edit_trick',["slug"=>$image->getTrick()->getSlug()]);

    }


    /**
     * Permet d'afficher un trick en lien avec son slug (param converter)
     * et enregistre les commentaires
     *
     * @Route("/trick/{slug}",name="show_trick")
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     * @throws Exception
     */
    public function show(Trick $trick, Request $request, ObjectManager $manager){

        $comment = new Comment();

        $formComment = $this->createForm(CommentType::class,$comment);

        $formComment->handleRequest($request);

        //si un commentaire est soumit
        if($formComment->isSubmitted() && $formComment->isValid()) {

            $comment->setTrick($trick);
            $comment->setUser($this->getUser());

            $dateComment = new DateTime();
            $comment->setCreatedAt($dateComment);

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Commentaire Ajouté"
            );

            return $this->redirectToRoute('show_trick', [
                'slug' => $trick->getSlug()
            ]);
        }

        return $this->render('trick/show.html.twig',[
            'trick' => $trick,
            'commentForm' => $formComment->createView()
        ]);
    }


    /**
     * Permet la mise a jour d'un trick
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @Route("/trick/{slug}/edit", name="edit_trick")
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @param FileUploader $fileUploader
     * @return RedirectResponse|Response
     * @throws Exception
     */
    public function edit(Trick $trick, Request $request, ObjectManager $manager, FileUploader $fileUploader){

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            //ajoute la date de modification
            $date = new DateTime();
            $trick->setModifiedAt($date);

            //recupere le fichier de la request
            $coverImage = $form['coverImage']->getData();

            if($coverImage)
            {
                //supprime l'ancienne image
                if($trick->getCoverImage()){
                    unlink('uploads/images/'.$trick->getCoverImage());
                }

                //charge la nouvelle image
                $coverImageName = $fileUploader->upload($coverImage);
                $trick->setCoverImage($coverImageName);
            }

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
     * @param Trick $trick
     * @param ObjectManager $manager
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

    /**
     * Permet l'ajout d'une video
     *
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @Route("/trick/{slug}/video", name="video_trick")
     *
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function ajoutVideo(Trick $trick, Request $request, ObjectManager $manager):Response{

        $video = new Video();

        $video->setTitle($request->get("title"));
        $video->setUrl($request->get("url"));

        $video->setTrick($trick);

        $manager->persist($video);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Video bien ajouté',
            'lastVideoTitle'=>$video->getTitle(),
            'lastVideoId'=>$video->getId(),
            'lastVideoUrl'=>$video->getUrl()

        ], 200);

    }


    /**
     * Permet l'ajout d'une Image
     *
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @Route("/trick/{slug}/image", name="image_trick")
     *
     * @param Trick $trick
     * @param Request $request
     * @param ObjectManager $manager
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function ajoutImage(Trick $trick, Request $request, ObjectManager $manager, FileUploader $fileUploader){

        $image = new Image();

        //recuperer le fichier de la request
        $fileImage = $request->files->get('url');
        $imageName = $fileUploader->upload($fileImage);

        $image->setTitle($request->get('title'));
        $image->setUrl($imageName);

        $image->setTrick($trick);

        $manager->persist($image);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Image bien ajouté',
            'lastImageTitle'=>$image->getTitle(),
            'lastImageId'=>$image->getId(),
            'lastImageUrl'=>$image->getUrl()

        ], 200);

    }

    /**
     * Pour la supression d'une image de trick
     *
     * @Security("is_granted('ROLE_USER') and user === video.getTrick().getAuthor()")
     *
     * @Route("/trick/video/{id}/delete",name="delete_video")
     * @param Video $video
     * @param ObjectManager $manager
     * @return RedirectResponse
     */
    public function deleteVideo(Video $video, ObjectManager $manager){

        $manager->remove($video);
        $manager->flush();

        $this->addFlash(
            'success',
            "La video à bien été supprimé"
        );
        return $this->redirectToRoute('edit_trick',["slug"=>$video->getTrick()->getSlug()]);

    }
}
