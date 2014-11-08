<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\PostCommentType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
            throw new NotFoundHttpException('这个评论不存在');
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

}
