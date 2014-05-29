<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * BlogController
 *
 * @Route("/blog")
 *
 * @author Ignacio Velázquez <ivelazquez85@gmail.com>
 */
class BlogController extends Controller
{
    /**
     * @Route("/", name="portfolio_blog_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        return $this->render(
            'AcmePortfolioBundle:Blog:index.html.twig',
            array(
                'section' => 'Blog'
            )
        );
    }

    /**
     * @Route("/{locale}.{_format}", name="portfolio_blog_list",
     * defaults={
     *      "_format": "html"
     * },
     * requirements={
     *        "locale" = "en|es"
     * })
     *
     * @param Request $request
     * @param         $locale
     *
     * @return Response
     */
    public function listAction(Request $request, $locale)
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

    /**
     * @Route("/{locale}/{slug}", name="portfolio_blog_show", requirements={
     *        "locale" = "en|es",
     *        "slug" = "[a-z\-]+[1-9]"
     * })
     *
     * @param $locale
     * @param $slug
     *
     * @return Response
     */
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
 