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
                'date' => new \DateTime('2014-02-21'),
                'rating' => 3.4,
                'locale' => 'es',
                'slug' => 'post-es-1',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
            array(
                'id' => 2,
                'date' => new \DateTime('2014-02-23'),
                'rating' => 2.9,
                'locale' => 'es',
                'slug' => 'post-es-2',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
            array(
                'id' => 3,
                'date' => new \DateTime('2014-02-27'),
                'rating' => 4.0,
                'locale' => 'es',
                'slug' => 'post-es-3',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
            array(
                'id' => 4,
                'date' => new \DateTime('2014-03-11'),
                'rating' => 5.2,
                'locale' => 'en',
                'slug' => 'post-en-1',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
            array(
                'id' => 5,
                'date' => new \DateTime('2014-03-15'),
                'rating' => 5,
                'locale' => 'en',
                'slug' => 'post-en-2',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
            array(
                'id' => 6,
                'date' => new \DateTime('2014-03-20'),
                'rating' => 7.7,
                'locale' => 'en',
                'slug' => 'post-en-3',
                'description' => 'This is a <span>long <b>long</b> description</span>'
            ),
        );
    }
}
 