<?php

namespace Acme\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Acme\PortfolioBundle\Entity\Post;
use Acme\PortfolioBundle\Entity\Comment;
use Acme\PortfolioBundle\Entity\Picture;

class LoadPostData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    const NUMBER_OF_POSTS = 100;
    const COMMENTS_PER_POST = 5;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $dm = $this->container->get('doctrine.orm.default_entity_manager');
        $categories = $dm->getRepository('AcmePortfolioBundle:Category')->findAll();

        for ($i = 1; $i <= self::NUMBER_OF_POSTS; $i++) {
            $post = new Post;
            $post
                ->setDate($faker->dateTimeThisYear)
                ->setRating($faker->randomFloat(1, 1, 10))
                ->setLocale($faker->languageCode)
                ->setSlug($faker->slug)
                ->setDescription($faker->text(1024))
                ;

            // Picture (unidirectional - cascade)
            $picture = new Picture();
            $picture
                ->setTitle($faker->text(255))
                ->setUrl($faker->imageUrl(32, 32, 'cats'))
                ;
            $post->setPicture($picture);

            // Comments (bidirectional - cascade)
            for($nComment = 1; $nComment <= self::COMMENTS_PER_POST; $nComment++) {
                $comment = new Comment();
                $comment->setText($faker->text(1024));

                $comment->setPost($post);
                $post->addComment($comment);
            }

            // Post - Categories
            $category = $categories[\array_rand($categories)];
            $post->addCategory($category);

            $manager->persist($post);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
