<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Category;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\CategoryType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
/**
 * Category controller.
 *
 */
class CategoryController extends ResourceController
{

    public function indexAction(Request $request)
    {

        $repo=$this->getRepository();

        $results=$repo->createPaginator(array('status'=>true),array('id'=>'desc'));

        $results->setCurrentPage($request->get('page', 1), true, true);
        $results->setMaxPerPage($this->config->getPaginationMaxPerPage());

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                'categories'    => $results
            ))
        ;

        return $this->handleView($view);
    }
        /**
     * Lists all Category entities.
     *

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Category');

         $query = $repo->createQueryBuilder('a')
            ->orderBy('a.no', 'desc')
            ->where('a.status = :status')
            ->setParameters(array('status' => true))
            ->getQuery();
        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:index.html.twig', array(
            'entities' => $entities,
        ));


    }
     */
    /**
     * Creates a new Category entity.
     *

    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_show', array('id' => $entity->getId())));
        }

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));


    }
     */
    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form

    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '创建'));

        return $form;
    }
     */
    /**
     * Displays a form to create a new Category entity.


    public function newAction()
    {
        $entity = new Category();
        $form   = $this->createCreateForm($entity);


        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));


    }
     */
    /**
     * Finds and displays a Category entity.
     *

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity =null;


        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Category')
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->andWhere('c.status = :status')
            ->setParameters(array(':id' => $id,'status'=>true))
            ->getQuery();

        try {
            $entity =  $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $post = null;
        }

        if (!$entity) {
            throw new NotFoundHttpException('这个分类不存在.');
        }


        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:show.html.twig', array(
            'entity' => $entity
        ));

    }
     */
    /**
     * Displays a form to edit an existing Category entity.
     *

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
     */
    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form

    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('admin_category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '修改'));

        return $form;
    }
    */
    /**
     * Edits an existing Category entity.
     *

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity =null;


        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Category')
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->andWhere('c.status = :status')
            ->setParameters(array(':id' => $id,'status'=>true))
            ->getQuery();

        try {
            $entity =  $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $post = null;
        }

        if (!$entity) {
            throw $this->createNotFoundException('这个分类不存在.');
        }


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_category_edit', array('id' => $id)));
        }

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Category:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView()
        ));


    }
    */
    /**
     * Deletes a Category entity.
     *

    public function deleteAction(Request $request, $id)
    {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('这个分类不存在.');
            }
            $entity->setModified(new \DateTime());
            $entity->setStatus(false);
           // $em->remove($entity);
            $em->flush();


        return $this->redirect($this->generateUrl('admin_category'));
    }
     */
    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除'))
            ->getForm()
        ;
    }
     */

    /**
     */
    public function enableAction(Request $request,$id)
    {
        $category =$this->getRepository()
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $category->setEnabled(true);
        $em->flush($category);
        return $this->redirect($this->generateUrl('bluehouseapp_category_index'));
    }

    /**
     */
    public function disableAction(Request $request,$id)
    {
        $category = $this->getRepository()
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $category->setEnabled(false);
        $em->flush($category);
        return $this->redirect($this->generateUrl('bluehouseapp_category_index'));
    }
}
