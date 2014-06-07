<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Template()
     * @Route("/", name="portfolio_blog_index")
     *
     * @return Response
     */
    public function indexAction()
    {
        return array(
            'section' => 'Blog'
        );
    }

    /**
     *
     * @Template()
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

        return array(
            'section' => 'Blog',
            'locale'  => $locale,
            'posts'   => $localePosts
        );
    }

    /**
     *
     * @Template()
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
                return array(
                    'section' => 'Blog',
                    'locale'  => $locale,
                    'post'   => $post
                );
            }
        }

        throw $this->createNotFoundException("Post with slug '" . $slug . "' not found");
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
 