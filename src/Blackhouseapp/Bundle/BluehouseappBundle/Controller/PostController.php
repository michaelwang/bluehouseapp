<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Post;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\PostType;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\PostCommentType;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Post controller.
 *
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @Route("/post/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $wh_content = $request->headers->get('WH-CONTEXT');

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Post');

        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.lastCommentTime', 'desc')
            ->where('a.status = :status')
            ->setParameters(array('status' => true))
            ->getQuery();

        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);
        $serializer = $this->get('jms_serializer');
        if ($wh_content == '' || $wh_content == null) {
            $lastComments = array();
            foreach ($entities  as $entity){
                $lastComments[$entity->getId()]=$this->get('blackhouseapp_bluehouseapp.post')->getLastComment($entity);

            }


            return array(
                'entities' => $entities,
                'lastComments' => $lastComments
            );
        } else {

            $data = array(
                'data' => $entities
            );
            $response = new Response($serializer->serialize($data, 'json'));
            $response->headers->set('Content-Type', 'text/html;; charset=utf-8');


            return $response;

        }


    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/member/post/", name="post_create")
     * @Method("POST")
     * @Template("BlackhouseappBluehouseappBundle:Post:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Post();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $current = $this->get('security.context')->getToken()->getUser();
            $entity->setMember($current);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create'),
            'method' => 'POST',
        ));



        return $form;
    }

    /**
     * Displays a form to create a new Post entity.
     *
     * @Route("/member/post/new", name="post_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Post();
        $form = $this->createCreateForm($entity);

        $current = $this->get('security.context')->getToken()->getUser();
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($current->getId());

        if( $member->getAvatar()!='')

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
        else{
            return $this->redirect($this->generateUrl('member_needAvatarImage', array()));
        }
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/post/{id}", name="post_show")
     * @Method("GET")
     * @Template()
     */
    public function  showAction(Request $request, $id)
    {
        $param = array();
        $wh_content = $request->headers->get('WH-CONTEXT');

        $em = $this->getDoctrine()->getManager();

        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Post')
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->andWhere('c.status = :status')
            ->setParameters(array(':id' => $id,'status'=>true))
            ->getQuery();

        try {
            $post =  $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $post = null;
        }

        if (!$post || !$post->getStatus()) {
            throw $this->createNotFoundException('这个帖子不存在');
        }
        $param['entity'] = $post;

        $page = $request->query->get('page', 1);
        $comments = $this->getComments($post, $page);
        $param['comments'] = $comments;

        $comment = new PostComment();
        $form = $this->getCommentForm($post, $comment);
        $param['form'] = $form->createView();
        if ($wh_content == '' || $wh_content == null) {
            return $param;
        } else {
            $data = array(
                'data' => $post,
                'comments' => $comments
            );
            $serializer = $this->get('jms_serializer');
            $response = new Response($serializer->serialize($data, 'json'));
            $response->headers->set('Content-Type', 'text/html;; charset=utf-8');


            return $response;
        }

    }


    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/manager/post/{id}/edit", name="post_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $editForm = $this->createEditForm($entity);
        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()

        );
    }

    /**
     * Creates a form to edit a Post entity.
     *
     * @param Post $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Post $entity)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing Post entity.
     *
     * @Route("/manager/post/{id}", name="post_update")
     * @Method("PUT")
     * @Template("BlackhouseappBluehouseappBundle:Post:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Post entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        $entity->setModified(new \DateTime());


        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('post_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        );
    }


        /**
     * Deletes a Post entity.
     *
     * @Route("/manager/post_delete/{id}", name="post_delete")
     * @Method({"GET","DELETE"})
     */
    public function deleteAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find($id);
        if($post){
            if (!$post) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }
            $post->setModified(new \DateTime());
            $post->setStatus(false);
          //  $em->remove($post);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('success','删除成功');
        return $this->redirect($this->generateUrl('post'));

    }



    /**
     * @Route("/member/post/comment/update/{id}",name="post_comment_create")
     * @Template("BlackhouseappBluehouseappBundle:Post:show.html.twig")
     * @Method({"POST"})
     */
    public function commentCreateAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find($id);
        if (!$post || !$post->getStatus()) {
            throw $this->createNotFoundException("这个帖子不存在");
        }
        $param['entity'] = $post;

        $comment = new PostComment();
        $form = $this->getCommentForm($post, $comment);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $current = $this->get('security.context')->getToken()->getUser();
            $comment->setPost($post);
            $comment->setMember($current);

            $em->persist($comment);
            $em->flush();
            $post = $comment->getPost();
            $post->setLastCommentTime(new \DateTime());
            $em->persist($post);
            $em->flush();

            return $this->redirect($this->generateUrl('post_show', array('id' => $post->getId())));
        }

        $param['form'] = $form->createView();

        $page = $request->query->get('page', 1);
        $comments = $this->getComments($post, $page);
        $param['comments'] = $comments;

        return $param;
    }

    private function getCommentForm($post, $comment)
    {
        $commentType = new PostCommentType();
        $form = $this->createForm($commentType, $comment, array(
            'action' => $this->generateUrl('post_comment_create', array('id' => $post->getId())),
            'method' => 'POST'
        ));
        return $form;
    }

    private function getComments($post, $page)
    {
        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:PostComment')
            ->createQueryBuilder('c')
            ->where('c.post = :post')
            ->andWhere('c.status = :status')
            ->setParameters(array(':post' => $post->getId(),'status'=>true))
            ->orderBy('c.id', 'asc')
            ->getQuery();
        $comments = $this->get('knp_paginator')->paginate($query, $page,50);
        return $comments;
    }


}
