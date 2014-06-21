<?php

namespace Acme\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\Form\PostType;
use Acme\PortfolioBundle\Entity\Post;

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
    public function createAction(Request $request)
    {
        // Create new Post
        $post = new Post();

        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Save into database
            $em = $this->get('doctrine.orm.default_entity_manager');

            $em->persist($post);
            $em->flush();

            // Inform user that a new Post has been created
            $this->get('session')->getFlashBag()->add('success', 'You have successfully create a new Post');

            // Redirect to list of posts
            return $this->redirect($this->generateUrl('admin_posts_list'));
        }

        return $this->render('AcmeAdminBundle:Posts:create.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="admin_posts_edit")
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');

        // Create new Post
        $post = $em->getRepository('Acme\PortfolioBundle\Entity\Post')->findOneById($id);

        $form = $this->createForm(new PostType(), $post);

        $form->handleRequest($request);

        if ($form->isValid()) {
            // Save into database

            $em->persist($post);
            $em->flush();

            // Inform user that a new Post has been created
            $this->get('session')->getFlashBag()->add('success', 'You have successfully update an existing Post');

            // Redirect to list of posts
            return $this->redirect($this->generateUrl('admin_posts_list'));
        }

        return $this->render('AcmeAdminBundle:Posts:edit.html.twig', array(
            'form' => $form->createView(),
            'post' => $post
        ));
    }
}
