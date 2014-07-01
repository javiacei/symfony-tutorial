<?php

namespace Acme\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Doctrine\ORM\Query\ResultSetMappingBuilder;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Acme\PortfolioBundle\Entity\Post;

/**
 * BlogController
 *
 * @Route("/{_locale}/blog", requirements={ "_locale" = "en|es" })
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
        $em = $this->get('doctrine.orm.default_entity_manager');

        $rsm = new ResultSetMappingBuilder($em);
        $rsm->addRootEntityFromClassMetadata('Acme\PortfolioBundle\Entity\Category', 'c');

        $query = $em->createNativeQuery("SELECT c.id, c.name FROM Category c", $rsm);
        $categories = $query->getResult();

        return array(
            'section' => $this->get('translator')->trans('Blog'),
            'categories' => $categories
        );
    }

    /**
     *
     * @Template()
     *
     * @Route(
     *      "/{categoryName}.{_format}",
     *      name="portfolio_blog_list",
     *      defaults={
     *          "_format": "html"
     *      }
     * )
     *
     * @param Request $request
     * @param         $categoryName
     *
     * @return Response
     */
    public function listAction(Request $request, $categoryName)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repository = $em->getRepository('Acme\PortfolioBundle\Entity\Post');

        $posts = $repository->getPostsOfCategoryWithName($categoryName);
        
        return array(
            'section' => $this->get('translator')->trans('Blog'),
            'categoryName' => $categoryName,
            'posts'        => $posts
        );
    }

    /**
     *
     * @Template()
     * @Route("/{categoryName}/{slug}", name="portfolio_blog_show", requirements={
     *        "categoryName" = "[a-z]+",
     *        "slug" = "[a-z\-]+"
     * })
     *
     * @param $categoryName
     * @param $slug
     *
     * @return Response
     */
    public function showAction($categoryName, $slug)
    {
        $post = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findOneBy(array(
                'slug' => $slug
            ));

        if (null === $post) {
            throw $this->createNotFoundException("Post with slug '" . $slug . "' not found");
        }

        return array(
            'section' => $this->get('translator')->trans('Blog'),
            'post'         => $post
        );
    }

    /**
     *
     * @Template()
     * @Route("/{categoryName}/{slug}/remove", name="portfolio_blog_remove", requirements={
     *        "categoryName" = "[a-z]+",
     *        "slug" = "[a-z\-]+"
     * })
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param $categoryName
     * @param $slug
     *
     * @return Response
     */
    public function removeAction($categoryName, $slug)
    {
        $dm = $this->get('doctrine.orm.default_entity_manager');

        $post = $dm
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findOneBy(array(
                'slug' => $slug
            ));

        if (null === $post) {
            throw $this->createNotFoundException("Post with slug '" . $slug . "' not found");
        }

        $dm->remove($post);
        $dm->flush();

        return $this->redirect($this->generateUrl('portfolio_blog_list', array(
            'categoryName' => $categoryName
        )));
    }
}
 
