<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * BlogController
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render(
            'AcmePortfolioBundle:Blog:index.html.twig',
            array(
                'section' => 'Blog'
            )
        );
    }

    public function listAction($locale)
    {
        return $this->render(
            'AcmePortfolioBundle:Blog:list.html.twig',
            array(
                'section' => 'Blog',
                'locale'  => $locale,
                'posts'   => $this->getPosts($locale)
            )
        );
    }

    public function showAction($locale, $slug)
    {
        $posts = $this->getPosts($locale);

        $index = array_search($slug, $posts);

        return $this->render(
            'AcmePortfolioBundle:Blog:show.html.twig',
            array(
                'section' => 'Blog',
                'locale'  => $locale,
                'post'   => $posts[$index]
            )
        );
    }

    public function getPosts($locale)
    {
        $posts = array(
            'en'  => array(
                'post-en-1',
                'post-en-2',
                'post-en-3',
                'post-en-4',
                'post-en-5',
            ),
            'es'  => array(
                'post-es-1',
                'post-es-2',
                'post-es-3',
                'post-es-4',
                'post-es-5',
            )
        );

        return $posts[$locale];
    }
}
 