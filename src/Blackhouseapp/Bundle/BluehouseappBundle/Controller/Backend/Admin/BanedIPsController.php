<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\BanedIPs;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\BanedIPsType;
use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
/**
 * BanedIPs controller.
 *
 */
class BanedIPsController extends ResourceController
{

/**
    public function indexAction(Request $request)
    {

        $repo=$this->getRepository();

        $results=$repo->createPaginator(array('status'=>true),array('id'=>'desc'));

        $results->setCurrentPage($request->get('page', 1), true, true);
        $results->setMaxPerPage($this->config->getPaginationMaxPerPage());
//        var_dump($results);exit;
        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setData(array(
                'banedIPs'    => $results
            ))
        ;

        return $this->handleView($view);
    }
**/


    /**
     * Lists all BanedIPs entities.
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->findAll();
        $view = $this -> view()
            ->setTemplate($this->config->getTemplate('index.html'))
            ->setTemplateVar($this->config->getPluralResourceName())
            ->setData($entities)
        ;
        return $this->handleView($view);
    }

    /**
     * Creates a new BanedIPs entity.
     *

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
        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));


    }
     */
    /**
     * Creates a form to create a BanedIPs entity.
     *
     * @param BanedIPs $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form

    private function createCreateForm(BanedIPs $entity)
    {
        $form = $this->createForm(new BanedIPsType(), $entity, array(
            'action' => $this->generateUrl('admin_banedips_create'),
            'method' => 'POST',
        ));


        return $form;
    }
     */
    /**
     * Displays a form to create a new BanedIPs entity.
     *

    public function newAction()
    {
        $entity = new BanedIPs();
        $form   = $this->createCreateForm($entity);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));


    }
     */
    /**
     * Finds and displays a BanedIPs entity.
     *

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find BanedIPs entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:show.html.twig', array(
            'entity' => $entity,
            'delete_form'   => $deleteForm->createView(),
        ));


    }
     */
    /**
     * Displays a form to edit an existing BanedIPs entity.

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:BanedIPs')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find BanedIPs entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));


    }
     */
    /**
    * Creates a form to edit a BanedIPs entity.
    *
    * @param BanedIPs $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form

    private function createEditForm(BanedIPs $entity)
    {
        $form = $this->createForm(new BanedIPsType(), $entity, array(
            'action' => $this->generateUrl('admin_banedips_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));



        return $form;
    }
    */

    /**
     * Edits an existing BanedIPs entity.
     *

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
        return $this->render('BlackhouseappBluehouseappBundle:Backend/Admin/BanedIPs:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));

    }
   */
    /**
     * Deletes a BanedIPs entity.

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
     */
    /**
     * Creates a form to delete a BanedIPs entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_banedips_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => '删除'))
            ->getForm()
        ;
    }



     */
}
