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
        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);

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

        $postcommentId = $request->query->get('postCommentId', 0);
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



}
