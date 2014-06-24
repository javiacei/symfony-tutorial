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
     * processForm
     *
     * @param Post $post
     * @param string $action
     * @return Response
     */
    private function processForm(Post $post, $action)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $request = $this->getRequest();

        $originalComments = new \Doctrine\Common\Collections\ArrayCollection();

        // Create an ArrayCollection of the current Comment objects in the database
        foreach ($post->getComments() as $comment) {
            $originalComments->add($comment);
        }

        $form = $this->createForm(new PostType(), $post);

        if ($form->handleRequest($request)->isValid()) {

            // Process comments
            foreach ($originalComments as $comment) {
                if (false === $post->getComments()->contains($comment)) {
                    // User has remove this comment
                    $em->remove($comment);
                }
            }

            // Inform user that a new Post has been created
            $flashMessage = ($post->getId()) 
                ? "Post with id '{$post->getId()}' updated successfully" 
                : 'New post created successfully';

            $this->get('session')->getFlashBag()->add('success', $flashMessage);

            // Save into database
            $em->persist($post);
            $em->flush();

            // Redirect to list of posts
            return $this->redirect($this->generateUrl('admin_posts_list'));
        }

        return $this->render('AcmeAdminBundle:Posts:form.html.twig', array(
            'form'   => $form->createView(),
            'post'   => $post,
            'action' => $action
        ));
    }

    /**
     * @Route("/create", name="admin_posts_create")
     */
    public function createAction(Request $request)
    {
        return $this->processForm(new Post(), 'create');
    }

    /**
     * @Route("/{id}/edit", name="admin_posts_edit")
     */
    public function editAction(Request $request, $id)
    {
        $post = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Post')
            ->findOneById($id)
        ;

        if (null === $post) {
            throw $this->createNotFoundException("Post with id '" . $id . "' not found");
        }

        return $this->processForm($post, 'edit');
    }
}
