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
            ->add('date')
            ->add('rating', 'number', array(
                'precision' => 1
            ))
            ->add('locale', 'country', array(
            ))
            ->add('slug', 'text')
            ->add('description', 'text')
            ->add('categories', 'entity', array(
                'class'    => 'Acme\PortfolioBundle\Entity\Category',
                'multiple' => true,
                'property' => 'name'
            ))
            // Embedded (1)
            ->add('picture', new PictureType())
            // Embedded (N)
            ->add('comments', 'collection', array(
                'type' => new CommentType()
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
