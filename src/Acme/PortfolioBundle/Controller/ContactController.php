<?php

namespace Acme\PortfolioBundle\Controller;

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
        $form = $this->createFormBuilder()
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('company', 'text')
            ->add('salary', 'choice', array(
                'choices' => array(10000, 20000),
                'expanded' => true
            ))
            ->add('currency', 'currency')
            ->add('contractDate', 'date')
            ->add('country', 'country')
            ->add('message', 'textarea')
            ->add('terms', 'checkbox')
            ->add('send', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->get('session')->getFlashBag()->add('success', 'You have successfully sent the request');

            return $this->redirect($this->generateUrl('portfolio_home_index'));
        }

        return $this->render(
            'AcmePortfolioBundle:Contact:index.html.twig',
            array(
                'section' => 'Contact',
                'form'    => $form->createView()
            )
        );
    }
}
 