<?php

namespace Acme\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/posts")
 */
class PostsController extends Controller
{
    /**
     * @Route("", name="admin_posts_index")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('admin_posts_list'));
    }

    /**
     * @Route("/", name="admin_posts_list")
     * @Template()
     */
    public function listAction()
    {
        $posts = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findBy(array(), array('date' => 'DESC'));

        return array(
            'posts' => $posts
        );
    }

    /**
     * @Route("/create", name="admin_posts_create")
     * @Template()
     */
    public function createAction()
    {
        return array();
    }
}
