<?php

namespace Acme\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Acme\PortfolioBundle\Entity\Category;

class LoadCategoryData implements FixtureInterface, OrderedFixtureInterface
{
    const NUMBER_OF_CATEGORIES = 4;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        for ($i = 1; $i <= self::NUMBER_OF_CATEGORIES; $i++) {
            $category = new Category();
            $category->setName($faker->text(255));

            $manager->persist($category);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
