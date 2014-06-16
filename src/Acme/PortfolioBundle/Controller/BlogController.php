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
     *
     * @Route(
     *      "/{locale}.{_format}",
     *      name="portfolio_blog_list",
     *      defaults={
     *          "_format": "html"
     *      }
     * )
     *
     * @param Request $request
     * @param         $locale
     *
     * @return Response
     */
    public function listAction(Request $request, $locale)
    {
        $posts = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findByLocale($locale);

        return array(
            'section' => 'Blog',
            'locale'  => $locale,
            'posts'   => $posts
        );
    }

    /**
     *
     * @Template()
     * @Route("/{locale}/{slug}", name="portfolio_blog_show", requirements={
     *        "locale" = "[a-z\-]{2}",
     *        "slug" = "[a-z\-]+"
     * })
     *
     * @param $locale
     * @param $slug
     *
     * @return Response
     */
    public function showAction($locale, $slug)
    {
        $post = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findOneBy(array(
                'locale' => $locale,
                'slug' => $slug
            ));

        if (null === $post) {
            throw $this->createNotFoundException("Post with slug '" . $slug . "' not found");
        }

        return array(
            'section' => 'Blog',
            'locale'  => $locale,
            'post'   => $post
        );
    }

    /**
     *
     * @Template()
     * @Route("/{locale}/{slug}/remove", name="portfolio_blog_remove", requirements={
     *        "locale" = "[a-z\-]{2}",
     *        "slug" = "[a-z\-]+"
     * })
     *
     * @param $locale
     * @param $slug
     *
     * @return Response
     */
    public function removeAction($locale, $slug)
    {
        $dm = $this->get('doctrine.orm.default_entity_manager');

        $post = $dm
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findOneBy(array(
                'locale' => $locale,
                'slug' => $slug
            ));

        if (null === $post) {
            throw $this->createNotFoundException("Post with slug '" . $slug . "' not found");
        }

        $dm->remove($post);
        $dm->flush();

        return $this->redirect($this->generateUrl('portfolio_blog_list', array(
            'locale' => $locale
        )));
    }
}
 
