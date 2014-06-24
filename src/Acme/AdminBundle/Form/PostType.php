<?php

namespace Acme\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PostType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', 'date', array(
                'required' => true
            ))
            ->add('rating', 'number', array(
                'precision' => 1,
                'required' => false
            ))
            ->add('locale', 'country', array(
                'required' => true
            ))
            ->add('slug', 'text', array(
                'required' => true,
                'max_length' => 255
            ))
            ->add('description', 'text', array(
                'required' => false
            ))
            ->add('categories', 'entity', array(
                'class'    => 'Acme\PortfolioBundle\Entity\Category',
                'multiple' => true,
                'property' => 'name',
                'required' => true
            ))
            // Embedded (1)
            ->add('picture', new PictureType(), array(
                'required' => false
            ))
            // Embedded (N)
            ->add('comments', 'collection', array(
                'type'         => new CommentType(),
                'allow_add'    => true,
                'allow_delete'    => true,
                'by_reference' => false
            ))
            ->add('send', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\PortfolioBundle\Entity\Post'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'acme_adminbundle_post';
    }
}
