<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * HomeController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class HomeController extends Controller
{
    /**
     * @Template()
     * @return Response
     */
    public function indexAction()
    {
        return array(
            'section' => 'Home'
        );
    }

    public function acceptCookiesAction(Request $request)
    {
        $this->get('session')->set('cookies_accepted', true);

        if (false == $request->isXmlHttpRequest()) {
            return $this->redirect($this->generateUrl('portfolio_home_index'));
        }

        return new Response();
    }

    /**
     * @Template("AcmePortfolioBundle:Home:current-job.html.twig")
     */
    public function currentJobAction()
    {
        return array(
            'company' => 'Google',
            'position' => 'General Manager'
        );
    }
}
 