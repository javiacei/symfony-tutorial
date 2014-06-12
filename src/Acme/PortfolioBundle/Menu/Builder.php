<?php

namespace Acme\PortfolioBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'portfolio_home_index'));
        $menu->addChild('About', array('route' => 'portfolio_about_index'));
        $menu->addChild('Blog', array('route' => 'portfolio_blog_index'));
        $menu->addChild('Contact', array('route' => 'portfolio_contact_index'));

        return $menu;
    }
}
