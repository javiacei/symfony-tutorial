<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
        $session = $this->get('session');

        if (false == $session->get('cookies_accepted')) {
            $session->getFlashBag()->add(
                'success',
                'By removing this alert you are accepting the following Cookie Policy'
            );
        }

        return $this->render(
            'AcmePortfolioBundle:Home:index.html.twig',
            array(
                'section' => 'Home'
            )
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
}
 