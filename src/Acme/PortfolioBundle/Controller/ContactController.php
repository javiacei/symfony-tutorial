<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * ContactController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class ContactController extends Controller
{
    public function indexAction()
    {
        return $this->render('AcmePortfolioBundle:Contact:index.html.twig');
    }
}
 