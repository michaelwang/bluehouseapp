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
 */
class PostCommentController extends Controller
{

    /**
     * Finds and displays a PostComment entity.
     *
     * @Route("/postcomment/{id}", name="postcomment_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Request $request, $id)
    {
        $param=array();


        $query = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:PostComment')
            ->createQueryBuilder('c')
            ->where('c.id = :id')
            ->andWhere('c.status = :status')
            ->setParameters(array(':id' => $id,'status'=>true))
            ->orderBy('c.id', 'asc')
            ->getQuery();
        try {
            $entity =  $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $entity = null;
        }

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
     *
     * @Route("/manager/postcomment/delete/{id}",name="postcomment_delete")
     * @Method({"GET","DELETE"})
     *
     */
    public function deletePostCommentAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $postComment = $em->getRepository('BlackhouseappBluehouseappBundle:PostComment')->find($id);
        if($postComment){
           // $em->remove($postComment);
            $postComment->setModified(new \DateTime());
            $postComment->setStatus(false);
            $em->flush();
            $em->persist($postComment->getPost());
            $em->flush();
        }
        $this->get('session')->getFlashBag()->add('success','删除成功');
        return $this->redirect($this->generateUrl('post_show', array('id' => $postComment->getPost()->getId())));
    }
}
