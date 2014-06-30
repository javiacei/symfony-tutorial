<?php

namespace Acme\PortfolioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\True;
Use Symfony\Component\Translation\TranslatorInterface;

/**
 * ContactType
 * 
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class ContactType extends AbstractType
{
    public $router;

    public function __construct(Router $router, TranslatorInterface $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction($this->router->generate('portfolio_contact_index'))
            ->add('name', 'text', array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => $this->translator->trans('Your name is required')
                    ))
                )
            ))
            ->add('email', 'email', array(
                'constraints' => array(
                    new NotBlank(array(
                        'message' => $this->translator->trans('Your email is required')
                    )),
                    new Email(),
                )
            ))
            ->add('company', 'text')
            ->add('salary', 'choice', array(
                'choices' => array(10000, 20000),
                'expanded' => true
            ))
            ->add('currency', 'currency')
            ->add('contractDate', 'date', array(
                'widget' => 'single_text'
            ))
            ->add('country', 'country')
            ->add('message', 'textarea', array(
                'constraints' => array(
                    new Length(array('min' => 5, 'max' => 50))
                )
            ))
            ->add('terms', 'checkbox', array(
                'constraints' => array(
                    new True(array(
                        'message' => $this->translator->trans('You must accept the terms and conditions')
                    ))
                )
            ))
            ->add('send', 'submit');
    }

    public function getName()
    {
        return 'contact';
    }
}
 
