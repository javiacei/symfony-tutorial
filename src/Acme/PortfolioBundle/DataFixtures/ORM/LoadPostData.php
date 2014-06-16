<?php

namespace Acme\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Acme\PortfolioBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $post1 = new Post();
        $post1
            ->setDate(new \DateTime('2014-02-21'))
            ->setRating(3.4)
            ->setLocale('es')
            ->setSlug('post-es-1')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;
        $manager->persist($post1);

        $post2 = new Post();
        $post2
            ->setDate(new \DateTime('2014-02-23'))
            ->setRating(4.2)
            ->setLocale('es')
            ->setSlug('post-es-2')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;
        $manager->persist($post2);

        $post3 = new Post();
        $post3
            ->setDate(new \DateTime('2014-02-25'))
            ->setRating(5)
            ->setLocale('en')
            ->setSlug('post-en-1')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;
        $manager->persist($post3);

        $post4 = new Post();
        $post4
            ->setDate(new \DateTime('2014-02-27'))
            ->setRating(8.4)
            ->setLocale('en')
            ->setSlug('post-en-2')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;
        $manager->persist($post4);

        $manager->flush();
    }
}
