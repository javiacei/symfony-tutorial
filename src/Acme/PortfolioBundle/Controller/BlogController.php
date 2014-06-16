<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Acme\PortfolioBundle\Entity\Post;

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
            if ($post->getLocale() === $locale) {
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
            if ($post->getLocale() === $locale && $post->getSlug() === $slug) {
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
        $post1 = new Post();
        $post1
            ->setDate(new \DateTime('2014-02-21'))
            ->setRating(3.4)
            ->setLocale('es')
            ->setSlug('post-es-1')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;

        $post2 = new Post();
        $post2
            ->setDate(new \DateTime('2014-02-23'))
            ->setRating(4.2)
            ->setLocale('es')
            ->setSlug('post-es-2')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;

        $post3 = new Post();
        $post3
            ->setDate(new \DateTime('2014-02-25'))
            ->setRating(5)
            ->setLocale('en')
            ->setSlug('post-en-1')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;

        $post4 = new Post();
        $post4
            ->setDate(new \DateTime('2014-02-27'))
            ->setRating(8.4)
            ->setLocale('en')
            ->setSlug('post-en-2')
            ->setDescription('This is a <span>long <b>long</b> description</span>')
        ;

        return array($post1, $post2, $post3, $post4);
    }
}
 
