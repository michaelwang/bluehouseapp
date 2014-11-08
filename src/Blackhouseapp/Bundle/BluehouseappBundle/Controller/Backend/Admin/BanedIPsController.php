<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\BanedIPs;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\BanedIPsType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * BanedIPs controller.
 *
 * @Route("/admin/banedips")
 */
class BanedIPsController extends Controller
{

    /**
     * Lists all BanedIPs entities.
     *
     * @Route("/", name="admin_banedips")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new BanedIPs entity.
     *
     * @Route("/", name="admin_banedips_create")
     * @Method("POST")
     * @Template("BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new BanedIPs();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_banedips_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a BanedIPs entity.
     *
     * @param BanedIPs $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BanedIPs $entity)
    {
        $form = $this->createForm(new BanedIPsType(), $entity, array(
            'action' => $this->generateUrl('admin_banedips_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new BanedIPs entity.
     *
     * @Route("/new", name="admin_banedips_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new BanedIPs();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a BanedIPs entity.
     *
     * @Route("/{id}", name="admin_banedips_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find BanedIPs entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing BanedIPs entity.
     *
     * @Route("/{id}/edit", name="admin_banedips_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find BanedIPs entity.');
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
    * Creates a form to edit a BanedIPs entity.
    *
    * @param BanedIPs $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BanedIPs $entity)
    {
        $form = $this->createForm(new BanedIPsType(), $entity, array(
            'action' => $this->generateUrl('admin_banedips_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));



        return $form;
    }
    /**
     * Edits an existing BanedIPs entity.
     *
     * @Route("/{id}", name="admin_banedips_update")
     * @Method("PUT")
     * @Template("BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BanedIPs entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_banedips_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a BanedIPs entity.
     *
     * @Route("/{id}", name="admin_banedips_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

            if (!$entity) {
                throw new NotFoundHttpException('Unable to find BanedIPs entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_banedips'));
    }

    /**
     * Creates a form to delete a BanedIPs entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_banedips_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除'))
            ->getForm()
        ;
    }
}
