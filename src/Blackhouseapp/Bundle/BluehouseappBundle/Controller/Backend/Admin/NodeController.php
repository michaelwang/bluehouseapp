<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Node;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\NodeType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
/**
 * Node controller.
 *
 */
class NodeController extends ResourceController
{
    /*
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
                    'nodes'    => $results
                ))
            ;

            return $this->handleView($view);


        }
    */
    /**
     * Lists all Node entities.

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Node');



        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.no', 'desc')
            ->where('a.status = :status')
            ->setParameters(array('status' => true))
            ->getQuery();
        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);


        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:index.html.twig', array(
            'entities' => $entities,
        ));

    }
     */


    /**
     * Creates a new Node entity.
     *

    public function createAction(Request $request)
    {
        $entity = new Node();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_node_show', array('id' => $entity->getId())));
        }
        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }
     */
    /**
     * Creates a form to create a Node entity.
     *
     * @param Node $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form

    private function createCreateForm(Node $entity)
    {
        $form = $this->createForm(new NodeType(false,$this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('admin_node_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => '创建'));

        return $form;
    }
     */
    /**
     * Displays a form to create a new Node entity.
     *

    public function newAction()
    {
        $entity = new Node();
        $form   = $this->createCreateForm($entity);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));


    }
     */
    /**
     * Finds and displays a Node entity.
     *

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('此节点不存在.');
        }

        $deleteForm = $this->createDeleteForm($id);



        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));


    }
     */
    /**
     * Displays a form to edit an existing Node entity.

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('此节点不存在.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));



    }
     */
    /**
    * Creates a form to edit a Node entity.
    *
    * @param Node $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form

    private function createEditForm(Node $entity)
    {
        $form = $this->createForm(new NodeType(true,$this->getDoctrine()->getManager()), $entity, array(
            'action' => $this->generateUrl('admin_node_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => '修改'));

        return $form;
    }
   */
    /**
     * Edits an existing Node entity.

    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('此节点不存在.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_node_edit', array('id' => $id)));
        }

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/Node:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));


    }
     */
    /**
     * Deletes a Node entity.
     *

    public function deleteAction(Request $request, $id)
    {

            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($id);

            if (!$entity) {
                throw new NotFoundHttpException('此节点不存在.');
            }
            $entity->setModified(new \DateTime());
            $entity->setStatus(false);
          //  $em->remove($entity);
            $em->flush();

        return $this->redirect($this->generateUrl('admin_node'));
    }
     */
    /**
     * Creates a form to delete a Node entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_node_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
     */

    /**
     */
    public function enableAction(Request $request,$id)
    {
        $node = $this->getRepository()
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $node->setEnabled(true);
        $em->flush($node);
        return $this->redirect($this->generateUrl('bluehouseapp_node_index'));
    }

    /**
     */
    public function disableAction(Request $request,$id)
    {
        $node = $this->getRepository()
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $node->setEnabled(false);
        $em->flush($node);
        return $this->redirect($this->generateUrl('bluehouseapp_node_index'));
    }



}
