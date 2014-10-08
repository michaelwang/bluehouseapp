<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\PostCommentType;
use Symfony\Component\HttpFoundation\Response;
/**
 * PostComment controller.
 *
 * @Route("/postcomment")
 */
class PostCommentController extends Controller
{

    /**
     * Lists all PostComment entities.
     *
     * @Route("/", name="postcomment")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PostComment entity.
     *
     * @Route("/", name="postcomment_create")
     * @Method("POST")
     * @Template("BlackhouseappBluehouseappBundle:PostComment:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PostComment();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
          //  $em->persist($entity);
         //   $em->flush();

            return $this->redirect($this->generateUrl('postcomment_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PostComment entity.
     *
     * @param PostComment $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PostComment $entity)
    {
        $form = $this->createForm(new PostCommentType(), $entity, array(
            'action' => $this->generateUrl('postcomment_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PostComment entity.
     *
     * @Route("/new", name="postcomment_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PostComment();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PostComment entity.
     *
     * @Route("/{id}", name="postcomment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $param=array();
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('这个评论不存在');
        }

        $wh_content=$request->headers->get('WH-CONTEXT');
      if($wh_content==''||$wh_content==null){
           $param = array(
              'entity' => $entity
          );
          return $param;
       }else
        {
            $data = array(
                'data' => $entity
            );
            $serializer = $this->get('jms_serializer');
            $response = new Response($serializer->serialize($data, 'json'));
            $response->headers->set('Content-Type', 'text/html;; charset=utf-8');


            return $response;
        }
    }

    /**
     * Displays a form to edit an existing PostComment entity.
     *
     * @Route("/{id}/edit", name="postcomment_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PostComment entity.');
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
    * Creates a form to edit a PostComment entity.
    *
    * @param PostComment $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PostComment $entity)
    {
        $form = $this->createForm(new PostCommentType(), $entity, array(
            'action' => $this->generateUrl('postcomment_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PostComment entity.
     *
     * @Route("/{id}", name="postcomment_update")
     * @Method("PUT")
     * @Template("BlackhouseappBluehouseappBundle:PostComment:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PostComment entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
           // $em->flush();

            return $this->redirect($this->generateUrl('postcomment_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PostComment entity.
     *
     * @Route("/{id}", name="postcomment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PostComment entity.');
            }

          //  $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('postcomment'));
    }

    /**
     * Creates a form to delete a PostComment entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postcomment_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
