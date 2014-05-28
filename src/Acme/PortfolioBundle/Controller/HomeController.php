<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * HomeController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class HomeController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'AcmePortfolioBundle:Home:index.html.twig',
            array(
                'section' => 'Home'
            )
        );
    }
}
 