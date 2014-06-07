<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Template()
 * ContactController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class ContactController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'AcmePortfolioBundle:Contact:index.html.twig',
            array(
                'section' => 'Contact'
            )
        );
    }
}
 