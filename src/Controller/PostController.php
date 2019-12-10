<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\PostLikeRepository;
use App\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * homepage => tous les posts
     *
     * @Route("/", name="homepage")
     * @param PostRepository $repo
     * @return Response
     */
    public function index(PostRepository $repo)
    {
        return $this->render('post/index.html.twig', [
            'posts' => $repo->findAll(),
        ]);
    }

    /**
     * pour voir un post
     *
     * @Route("/post/{id<^[0-9]+$>}", name="post_by_id")
     * @param $id
     * @return Response
     */
    public function postById($id)
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findOneBy(['id' => $id ]);
//        var_dump($post->getComments());
        $comments = $this->getDoctrine()
            ->getRepository(Comment::class)
            ->findBy(['post' => $post ]);
//        var_dump($comments);

        return $this->render('post/postById.html.twig', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }

    /**
     * permet de like ou unliker un article
     *
     * @Route("/post/{id}/like", name="post_like")
     *
     * @param Post $post
     * @param ObjectManager $manager
     * @param PostLikeRepository $postLikeRepo
     * @return Response
     */
    public function like(Post $post, ObjectManager $manager, PostLikeRepository $postLikeRepo) : Response
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

        // cas numéro 2 = user aime deja l'article
        if ($post->isLikedByUser($user)) {
            $like = $postLikeRepo->findOneBy(['user' => $user, 'post' => $post]);
            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'like supprimé',
                'likes' => $postLikeRepo->count(['post' => $post]),
            ], 200);
        }

        // cas numéro 3 = user n'aime pas encore le l'article, le post
        $like = new PostLike();
        $like->setUser($user)
            ->setPost($post);
        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'j\'aime ajouté',
            'likes' => $postLikeRepo->count(['post' => $post]),
        ], 200);
    }
}
