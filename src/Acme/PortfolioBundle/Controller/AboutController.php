<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * AboutController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class AboutController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmePortfolioBundle:About:index.html.twig');
    }
}
 