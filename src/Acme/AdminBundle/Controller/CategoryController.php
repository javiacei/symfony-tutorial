<?php

namespace Acme\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

use Acme\AdminBundle\Form\CategoryType;
use Acme\PortfolioBundle\Entity\Category;

/**
 * @Route("/categories")
 */
class CategoryController extends Controller
{
    /**
     * @Route("", name="admin_category_index")
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('admin_category_list'));
    }

    /**
     * @Route("/", name="admin_category_list")
     * @Template()
     */
    public function listAction()
    {
        $categories = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Category')
            ->findBy(array(), array('id' => 'DESC'));

        return array(
            'categories' => $categories
        );
    }

    /**
     * processForm
     *
     * @param Category $category
     * @param string $action
     * @return Response
     */
    private function processForm(Category $category, $action)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $request = $this->getRequest();

        $form = $this->createForm(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid()) {
            // Inform user that a new category has been created
            $flashMessage = ($category->getId()) 
                ? "Category with id '{$category->getId()}' updated successfully" 
                : 'New category created successfully';

            $this->get('session')->getFlashBag()->add('success', $flashMessage);

            // Save into database
            $em->persist($category);
            $em->flush();

            // Redirect to list of categories
            return $this->redirect($this->generateUrl('admin_category_list'));
        }

        return $this->render('AcmeAdminBundle:Category:form.html.twig', array(
            'form'     => $form->createView(),
            'category' => $category,
            'action'   => $action
        ));
    }

    /**
     * @Route("/create", name="admin_category_create")
     */
    public function createAction(Request $request)
    {
        return $this->processForm(new Category(), 'create');
    }

    /**
     * @Route("/{id}/edit", name="admin_category_edit")
     */
    public function editAction(Request $request, $id)
    {
        $category = $this
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('Acme\PortfolioBundle\Entity\Category')
            ->findOneById($id)
        ;

        if (null === $category) {
            throw $this->createNotFoundException("Category with id '" . $id . "' not found");
        }

        return $this->processForm($category, 'edit');
    }
}
