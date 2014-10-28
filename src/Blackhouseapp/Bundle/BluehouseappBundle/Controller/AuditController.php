<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Audit;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\AuditType;

/**
 * Audit controller.
 *
 * @Route("/admin/audit")
 */
class AuditController extends Controller
{

    /**
     * Lists all Audit entities.
     *
     * @Route("/", name="admin_audit")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo=$em->getRepository('BlackhouseappBluehouseappBundle:Audit');
        $query = $repo->createQueryBuilder('a')
            ->where('a.status = :status')
            ->setParameters(array('status'=>true ))
            ->orderBy('a.id','desc')
            ->getQuery();
        $page = $request->query->get('page', 1);
        $entities = $this->get('knp_paginator')->paginate($query, $page, 100);

        return array(
            'entities' => $entities,
        );
    }



    /**
     * Deletes a Post entity.
     *
     * @Route("/post_delete", name="admin_audit_post_delete")
     * @Method({"GET","DELETE"})
     */
    public function deletePostAction(Request $request)
    {

        $postId = $request->query->get('postId', 0);
        $auditId = $request->query->get('auditId', 0);

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find($postId);

        if ($post) {
            if (!$post) {
                throw $this->createNotFoundException('此帖不存在.');
            }
            $post->setModified(new \DateTime());
            $post->setStatus(false);
            $em->flush();

            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($auditId);
            if (!$entity) {
                throw $this->createNotFoundException('此审计不存在.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_audit'));

    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/postcomment_delete", name="admin_audit_postcomment_delete")
     * @Method({"GET","DELETE"})
     */
    public function deletePostCommentAction(Request $request)
    {

        $postcommentId = $request->query->get('postcommentId', 0);
        $auditId = $request->query->get('auditId', 0);

        $em = $this->getDoctrine()->getManager();
        $postComment = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($postcommentId);

        if ($postComment) {
            if (!$postComment) {
                throw $this->createNotFoundException('此评论不存在.');
            }
            $postComment->setModified(new \DateTime());
            $postComment->setStatus(false);
            $em->flush();

            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($auditId);
            if (!$entity) {
                throw $this->createNotFoundException('此审计不存在.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_audit'));

    }



    /**
     * Creates a new Audit entity.
     *
     * @Route("/", name="admin_audit_create")
     * @Method("POST")
     * @Template("BlackhouseappBluehouseappBundle:Audit:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Audit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_audit_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Audit entity.
     *
     * @param Audit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Audit $entity)
    {
        $form = $this->createForm(new AuditType(), $entity, array(
            'action' => $this->generateUrl('admin_audit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Audit entity.
     *
     * @Route("/new", name="admin_audit_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Audit();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Audit entity.
     *
     * @Route("/{id}", name="admin_audit_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Audit entity.
     *
     * @Route("/{id}/edit", name="admin_audit_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audit entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Audit entity.
    *
    * @param Audit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Audit $entity)
    {
        $form = $this->createForm(new AuditType(), $entity, array(
            'action' => $this->generateUrl('admin_audit_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Audit entity.
     *
     * @Route("/{id}", name="admin_audit_update")
     * @Method("PUT")
     * @Template("BlackhouseappBluehouseappBundle:Audit:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Audit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_audit_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Audit entity.
     *
     * @Route("/{id}", name="admin_audit_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Audit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Audit entity.');
            }

          //  $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_audit'));
    }

    /**
     * Creates a form to delete a Audit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_audit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
