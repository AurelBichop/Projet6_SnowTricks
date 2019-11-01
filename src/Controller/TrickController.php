<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
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
     * Pour la supression d'une image de trick
     *
     * @Route("/trick/image/{id}/delete",name="delete_image")
     * @Security("is_granted('ROLE_USER') and user === image.getTrick().getAuthor()")
     *
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
     * @param CommentRepository $commentRepository
     * @return Response
     * @throws Exception
     */
    public function show(Trick $trick, Request $request, ObjectManager $manager, CommentRepository $commentRepository){

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
            'comments'=>$commentRepository->findBy(['trick'=>$trick->getId()],['id'=>'DESC'],5) ,
            'nbComments' =>count($trick->getComment()),
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
     * @Route("/trick/{slug}/delete", name="delete_trick", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user === trick.getAuthor()")
     *
     * @param Request $request
     * @param Trick $trick
     * @return Response
     */
    public function delete(Request $request, Trick $trick): Response
    {

        if ($this->isCsrfTokenValid('delete'.$trick->getSlug(), $request->request->get('_token'))){
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($trick);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le trick {$trick->getTitre()} à bien été supprimé"
            );
        }else{
            $this->addFlash(
                'Erreur',
                "Le trick {$trick->getTitre()} n'a pas été supprimé"
            );
        }

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

        $title = htmlspecialchars($request->get("title"));
        $url = $request->get("url");

        //reconstruit l'url de la source
        $urlEmbed = $this->sourceVideo($url);

        //retour d'un message si la vidéo ne provient pas des sources
        //( dailymotion ou youtube )
        if($urlEmbed === null){
            return $this->json([

                'message' => 'Erreur mauvaise Url pour la video',

            ], 200);
        }

        $video->setTitle($title);
        $video->setUrl($urlEmbed);

        $video->setTrick($trick);

        $manager->persist($video);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'lastVideoTitle'=>$video->getTitle(),
            'lastVideoId'=>$video->getId(),
            'lastVideoUrl'=>$video->getUrl()

        ], 200);

    }

    /**
     * Permet de retourner une url embed pour youtube ou dailymotion
     *
     * @param $url
     * @return string|null
     */
    private function sourceVideo($url):?string {

        if(strpos($url,'www.dailymotion.com')){

            $ex = explode('/',$url);
            $url = 'https://www.dailymotion.com/embed/video/'.end($ex);

            return $url;

        }elseif (strpos($url,'www.youtube.com/watch?v')){

            $ex = explode('=',$url);
            $url = 'https://www.youtube.com/embed/'.$ex[1];

            return $url;
        }

        return null;
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

        $image->setTitle(htmlspecialchars($request->get('title')));
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
     * Pour la supression d'une video de trick
     *
     * @Route("/trick/video/{id}/delete",name="delete_video")
     * @Security("is_granted('ROLE_USER') and user === video.getTrick().getAuthor()")
     *
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

    /**
     * @Route("/trick/{slug}/more",name="more_comment")
     * @param Trick $trick
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function loadMore(Trick $trick, CommentRepository $commentRepository, Request $request):JsonResponse{

        $datas = [];
        $depart = (int)$request->get('nbComment');
        $nbEnplus = 5;

        //Pour tester dans des conditions Web
        //sleep(5);

        $listeMoreComment = $commentRepository->findBy(
            ['trick'=>$trick->getId()],
            ['id'=>'DESC'],
            $limit = $nbEnplus,
            $offset = $depart
        );


        foreach ( $listeMoreComment as $key => $item) {
            $datas[$key]['id'] = $item->getId();
            $datas[$key]['contentCom'] = htmlspecialchars(nl2br($item->getContent()));
            $datas[$key]['createdAt'] = $item->getCreatedAt()->format('d/m/Y');
            $datas[$key]['author'] = $item->getUser()->getFirstName();
        }

        return new JsonResponse($datas);

    }
}
