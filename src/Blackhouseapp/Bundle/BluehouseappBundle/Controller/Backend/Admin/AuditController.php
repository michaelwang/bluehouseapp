<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;

use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Audit;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
/**
 * Audit controller.
 *
 */
class AuditController extends ResourceController
{

    /**
     * Lists all Audit entities.
     */    
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
                'entities'    => $results
            ))
        ;

        return $this->handleView($view);

    }



    /**
     * Deletes a Post entity.
     *
     */
    public function deletePostAction(Request $request)
    {

        $postId = $request->query->get('postId', 0);
        $auditId = $request->query->get('auditId', 0);

        $em = $this->getDoctrine()->getManager();
        $post = $this->get('bluehouseapp.repository.post')->find($postId);

        if ($post) {
            if (!$post) {
                throw new NotFoundHttpException('此帖不存在.');
            }
            $post->setModified(new \DateTime());
            $post->setStatus(false);
            $em->flush();

            $entity = $this->getRepository()->find($auditId);
            if (!$entity) {
                throw new NotFoundHttpException('此审计不存在.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bluehouseapp_audit_index'));

    }

    /**
     * Deletes a Post entity.
     */
    public function deletePostCommentAction(Request $request)
    {

        $postcommentId = $request->query->get('postCommentId', 0);
        $auditId = $request->query->get('auditId', 0);

        $em = $this->getDoctrine()->getManager();
        $postComment = $this->get('bluehouseapp.repository.postcomment')->find($postcommentId);

        if ($postComment) {
            if (!$postComment) {
                throw new NotFoundHttpException('此评论不存在.');
            }
            $postComment->setModified(new \DateTime());
            $postComment->setStatus(false);
            $em->flush();

            $entity = $this->getRepository()->find($auditId);
            if (!$entity) {
                throw new NotFoundHttpException('此审计不存在.');
            }
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bluehouseapp_audit_index'));

    }



}
