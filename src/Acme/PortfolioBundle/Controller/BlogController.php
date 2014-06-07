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
        $localePosts = array();
        $posts = $this->getPosts();

        foreach($posts as $post) {
            if ($post['locale'] === $locale) {
                $localePosts[] = $post;
            }
        }

        return $this->render(
            'AcmePortfolioBundle:Blog:list.html.twig',
            array(
                'section' => 'Blog',
                'locale'  => $locale,
                'posts'   => $localePosts
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
        $posts = $this->getPosts();

        foreach($posts as $post) {
            if ($post['locale'] === $locale && $post['slug'] === $slug) {
                return $this->render(
                    'AcmePortfolioBundle:Blog:show.html.twig',
                    array(
                        'section' => 'Blog',
                        'locale'  => $locale,
                        'post'   => $post
                    )
                );
            }
        }

        return $this->redirect($this->generateUrl('portfolio_home_index'));

        return $this->forward('AcmePortfolioBundle:Blog:list', array(
            'locale'  => $locale
        ));
    }

    public function getPosts()
    {
        return array(
            array(
                'id' => 1,
                'locale' => 'es',
                'slug' => 'post-es-1',
                'description' => 'description'
            ),
            array(
                'id' => 2,
                'locale' => 'es',
                'slug' => 'post-es-2',
                'description' => 'description'
            ),
            array(
                'id' => 3,
                'locale' => 'es',
                'slug' => 'post-es-3',
                'description' => 'description'
            ),
            array(
                'id' => 4,
                'locale' => 'en',
                'slug' => 'post-en-1',
                'description' => 'description'
            ),
            array(
                'id' => 5,
                'locale' => 'en',
                'slug' => 'post-en-2',
                'description' => 'description'
            ),
            array(
                'id' => 6,
                'locale' => 'en',
                'slug' => 'post-en-3',
                'description' => 'description'
            ),
        );
    }
}
 