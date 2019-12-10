<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\CommentLike;
use App\Repository\CommentLikeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
//    /**
//     * @Route("/comment", name="comment")
//     */
//    public function index()
//    {
//        return $this->render('comment/index.html.twig', [
//            'controller_name' => 'CommentController',
//        ]);
//    }


    /**
     * permet de liker ou unliker un commentaire avec reponse en json, pour ajax.
     *
     * @Route("/comment/{id}/like", name="comment_like")
     * @param Comment $comment
     * @param ObjectManager $manager
     * @param CommentLikeRepository $commentLikeRepository
     * @return Response
     */
    public function likeComment(Comment $comment, ObjectManager $manager, CommentLikeRepository $commentLikeRepository) :Response
    {
        //recupère l'utilisateur connecté
        $user  = $this->getUser();

        //cas numero 1 = user non connecté
        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => 'non autorisé'
            ], 403);
        }

        // cas numéro 2 = user aime deja le commentaire
        if ($comment->isLikedByUser($user)) {
            $commentLike = $commentLikeRepository->findOneBy(['user' => $user, 'comment' => $comment]);
            $manager->remove($commentLike);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
                'commentLikes' => $commentLikeRepository->count(['comment' => $comment]),
            ], 200);
        }

        // cas numéro 3 = user n'a pas clické sur j'aime
        $commentLike = new CommentLike();
        $commentLike->setUser($user)
            ->setComment($comment);
        $manager->persist($commentLike);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'j\'aime ajouté',
            'commentLikes' => $commentLikeRepository->count(['comment' => $comment]),
        ], 200);

    }
}
