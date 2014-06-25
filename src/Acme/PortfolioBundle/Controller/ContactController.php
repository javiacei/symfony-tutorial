<?php

namespace Acme\PortfolioBundle\Controller;

use Acme\PortfolioBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ContactType($this->get('router')));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('session')->getFlashBag()->add('success', 'You have successfully sent the request');

            return $this->redirect($this->generateUrl('portfolio_home_index'));
        }

        return $this->render(
            'AcmePortfolioBundle:Contact:index.html.twig',
            array(
                'section' => $this->get('translator')->trans('Contact'),
                'form'    => $form->createView()
            )
        );
    }
}
 
