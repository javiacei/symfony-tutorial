<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * BlogController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'AcmePortfolioBundle:Blog:index.html.twig',
            array(
                'section' => 'Blog'
            )
        );
    }
}
 