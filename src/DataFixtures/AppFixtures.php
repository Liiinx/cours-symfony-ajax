<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\PostLike;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * Encodeur de mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $users = [];
        $posts = [];

        $user = new User();
        $user->setEmail('user@symfony.com')
            ->setPassword($this->encoder->encodePassword($user, 'password'));
        $manager->persist($user);

        $users[] = $user;

        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'password'));

            $manager->persist($user);
            $users[] = $user;
        }
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitle($faker->sentence(5))
                ->setIntroduction($faker->paragraph())
                ->setContent('<p>' . join(',', $faker->paragraphs()) . '</p>');

            $manager->persist($post);
            $posts[] = $post;

            for ($j = 0; $j < mt_rand(0, 10); $j++) {
                $like = new PostLike();
                $like->setPost($post)
                    ->setUser($faker->randomElement($users));

                $manager->persist($like);
            }
        }
        for ($i = 0; $i < 40; $i++) {
            $comment = new Comment();
            $comment->setContent($faker->paragraph(3))
                ->setUser($faker->randomElement($users))
                ->setPost($faker->randomElement($posts));
            $manager->persist($comment);

        }
        $manager->flush();
    }
}
