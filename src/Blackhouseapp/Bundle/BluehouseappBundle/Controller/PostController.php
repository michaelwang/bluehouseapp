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
     * @Route("/post/node/{currentNodeId}", name="post_by_node")
     * @Method("GET")
     */
    public function listPostsByNodeAction(Request $request,$currentNodeId=0)
    {
        $wh_content = $request->headers->get('WH-CONTEXT');

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);

        $categories = $this->get('blackhouseapp_bluehouseapp.post')->getAllEnableCategories();

        $currentCategory = null;
        $currentNode = null;
        if($currentNodeId==0){
            if (count($categories) > 0) {
                $currentCategory = $categories[0];
                $currentCategoryId=$currentCategory->getId();
            }
        }else{
            $currentNode = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($currentNodeId);

            if (!$currentNode) {
                throw $this->createNotFoundException('此节点不存在.');
            }


        }
        if($currentCategory!=null){
            $nodes = $currentCategory->getNodes();

            if (count($nodes) > 0) {
                $currentNode = $nodes[0];
            }
        }

        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Post');

        $query = $repo->createQueryBuilder('p')
            ->innerJoin('p.node', 'n')
            ->innerJoin('p.member', 'm')
            ->innerJoin('n.category', 'c')
            ->orderBy('p.lastCommentTime', 'desc')
            ->where('n.id = :currentNodeId')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('n.status = :nodeStatus')
            ->andWhere('n.enabled = :nodeEnabled')
            ->andWhere('c.status = :cStatus')
            ->andWhere('c.enabled = :cEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array('currentNodeId' =>$currentNodeId,
                'postStatus' => true,'postEnabled' => true,
                'nodeStatus'=>true,'nodeEnabled'=>true,
                'cStatus'=>true,'cEnabled'=>true,
                'mLocked'=>false
            ))
            ->getQuery();

        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);
        $serializer = $this->get('jms_serializer');

        if ($wh_content == '' || $wh_content == null) {
            $lastComments = array();
            foreach ($entities as $entity) {
                $lastComments[$entity->getId()] = $this->get('blackhouseapp_bluehouseapp.post')->getLastComment($entity);
            }

            $postCounts= $this->get('blackhouseapp_bluehouseapp.post')->countPostsByNode($currentNodeId);

            return $this->render('BlackhouseappBluehouseappBundle:Post:postsByNode.html.twig',

                array(
                    'entities' => $entities,
                    'categories' => $categories,
                    'lastComments' => $lastComments,
                    'currentCategory' => $currentCategory,
                    'currentNode' => $currentNode,
                    'postCounts'=>$postCounts

                )
            );

            //  return;
        }
        else
        return array();
    }

    /**
     * Lists all Post entities.
     *
     * @Route("/post/category/{currentCategoryId}", name="post_by_category")
     * @Method("GET")
     */
    public function listPostsByCategoryAction(Request $request,$currentCategoryId=0)
    {
        $wh_content = $request->headers->get('WH-CONTEXT');

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);

        $categories = $this->get('blackhouseapp_bluehouseapp.post')->getAllEnableCategories();

        $currentCategory = null;
        $currentNode = null;
        if($currentCategoryId==0){
        if (count($categories) > 0) {
            $currentCategory = $categories[0];
            $currentCategoryId=$currentCategory->getId();
        }
        }else{
            foreach ($categories as $category) {
                if($currentCategoryId==$category->getId()){
                    $currentCategory=$category;
                    break;
                }
            }
            if (!$currentCategory) {
                throw $this->createNotFoundException('此分类不存在.');
            }

        }
    if($currentCategory!=null){
        $nodes = $currentCategory->getNodes();

        if (count($nodes) > 0) {
            $currentNode = $nodes[0];
        }
    }

        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Post');

        $query = $repo->createQueryBuilder('p')
            ->innerJoin('p.node', 'n')
            ->innerJoin('p.member', 'm')
            ->innerJoin('n.category', 'c')
            ->orderBy('p.lastCommentTime', 'desc')
             ->where('c.id = :categoryId')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('n.status = :nodeStatus')
            ->andWhere('n.enabled = :nodeEnabled')
            ->andWhere('c.status = :cStatus')
            ->andWhere('c.enabled = :cEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array( 'categoryId' => ($currentCategory==null?0:$currentCategory->getId()),
                'postStatus' => true,'postEnabled' => true,
                'nodeStatus'=>true,'nodeEnabled'=>true,
                'cStatus'=>true,'cEnabled'=>true,
                'mLocked'=>false

            ))
            ->getQuery();

        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);
        $serializer = $this->get('jms_serializer');

        if ($wh_content == '' || $wh_content == null) {
            $lastComments = array();
            foreach ($entities as $entity) {
                $lastComments[$entity->getId()] = $this->get('blackhouseapp_bluehouseapp.post')->getLastComment($entity);
            }


            return $this->render('BlackhouseappBluehouseappBundle:Post:index.html.twig',

                array(
                    'entities' => $entities,
                    'categories' => $categories,
                    'lastComments' => $lastComments,
                    'currentCategory' => $currentCategory,
                    'currentNode' => $currentNode

                )
            );

          //  return;
        }
            return array();
    }
    /**
     * Lists all Post entities.
     *
     * @Route("/post/", name="post")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
/*
        $wh_content = $request->headers->get('WH-CONTEXT');

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);

        $categories = $this->get('blackhouseapp_bluehouseapp.post')->getAllEnableCategories();

        $currentCategory = null;
        $currentNode = null;
        if (count($categories) > 0) {
            $currentCategory = $categories[0];
        }
        $nodes = $currentCategory->getNodes();

        if (count($nodes) > 0) {
            $currentNode = $nodes[0];
        }
        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Post');

        $query = $repo->createQueryBuilder('p')
            ->innerJoin('p.node', 'n')
            ->innerJoin('n.category', 'c')
            ->orderBy('p.lastCommentTime', 'desc')
            ->where('p.status = :status')
            ->andWhere('c.id = :categoryId')
            ->setParameters(array('status' => true, 'categoryId' => $currentCategory->getId()))
            ->getQuery();

        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);
        $serializer = $this->get('jms_serializer');

        if ($wh_content == '' || $wh_content == null) {
              return $this->redirect($this->generateUrl('post_by_category'));
        } else {

            $data = array(
                'data' => $entities
            );
            $response = new Response($serializer->serialize($data, 'json'));
            $response->headers->set('Content-Type', 'text/html;; charset=utf-8');
            return $response;

        }
*/
        return $this->redirect($this->generateUrl('post_by_category'));
    }

    /**
     * Creates a new Post entity.
     *
     * @Route("/member/post/{nodeId}", name="post_create")
     * @Method("POST")
     * @Template("BlackhouseappBluehouseappBundle:Post:new.html.twig")
     */
    public function createAction(Request $request,$nodeId)
    {
        $entity = new Post();
        $form = $this->createCreateForm($entity,$nodeId);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $current = $this->get('security.context')->getToken()->getUser();
            $entity->setMember($current);
            $em = $this->getDoctrine()->getManager();
            $node = $em->getRepository('BlackhouseappBluehouseappBundle:Node')->find($nodeId);
            $entity->setNode($node);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('post_by_category',array('currentCategoryId' => $entity->getNode()->getCategory()->getId())));
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
    private function createCreateForm(Post $entity,$currentNodeId)
    {
        $form = $this->createForm(new PostType(), $entity, array(
            'action' => $this->generateUrl('post_create',array('nodeId' =>$currentNodeId)),
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
    public function newAction(Request $request)
    {
        $nodeId = $request->query->get('nodeId', 0);

        $currentNode=$this->get('blackhouseapp_bluehouseapp.post')->getNode($nodeId);


        $entity = new Post();
        $entity->setNode($currentNode);

        $nodes=$currentNode->getCategory()->getNodes();

        $form = $this->createCreateForm($entity,$nodeId);

        $current = $this->get('security.context')->getToken()->getUser();
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($current->getId());

        if ($member->getAvatar() != '')

            return array(
                'entity' => $entity,
                'form' => $form->createView(),
            );
        else {
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


        $post =$this->get('blackhouseapp_bluehouseapp.post')->getPost($id);


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

        $entity =$this->get('blackhouseapp_bluehouseapp.post')->getPost($id);

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

        $entity = $this->get('blackhouseapp_bluehouseapp.post')->getPost($id);

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
        $post =$this->get('blackhouseapp_bluehouseapp.post')->getPost($id);
        if ($post) {
            if (!$post) {
                throw $this->createNotFoundException('Unable to find Post entity.');
            }
            $post->setModified(new \DateTime());
            $post->setStatus(false);
            //  $em->remove($post);
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('success', '删除成功');
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
        $post =$this->get('blackhouseapp_bluehouseapp.post')->getPost($id);
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
            ->createQueryBuilder('pc')
            ->innerJoin('pc.member', 'm')
            ->innerJoin('pc.post', 'p')
            ->where('pc.post = :post')
            ->andWhere('pc.status = :pcStatus')
            ->andWhere('pc.enabled = :pcEnabled')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array(':post' => $post,
                 'pcStatus' => true, 'pcEnabled' => true,
                'postStatus' => true,'postEnabled' => true,
                'mLocked'=>false
            ))
            ->orderBy('pc.id', 'asc')
            ->getQuery();
        $comments = $this->get('knp_paginator')->paginate($query, $page, 50);
        return $comments;
    }


}
