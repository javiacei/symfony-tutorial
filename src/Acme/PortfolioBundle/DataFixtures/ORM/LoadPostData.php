<?php

namespace Acme\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Acme\PortfolioBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    const NUMBER_OF_POSTS = 100;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= self::NUMBER_OF_POSTS; $i++) {
            $post = new Post;
            $post
                ->setDate($faker->dateTimeThisYear)
                ->setRating($faker->randomFloat(1, 1, 10))
                ->setLocale($faker->languageCode)
                ->setSlug($faker->slug)
                ->setDescription($faker->text(1024))
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
