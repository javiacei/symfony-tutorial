<?php

namespace Acme\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Acme\PortfolioBundle\Entity\User;
use Acme\PortfolioBundle\Entity\Role;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole->setName('Admin Role')->setRole('ROLE_ADMIN');

        $manager->persist($adminRole);

        $user = new User();
        $user
            ->setUsername('admindb')
            ->setPassword(password_hash('admindb', PASSWORD_BCRYPT, array('cost' => 12)))
            ->addRole($adminRole)
        ;


        $manager->persist($user);
        $manager->flush();
    }
}
