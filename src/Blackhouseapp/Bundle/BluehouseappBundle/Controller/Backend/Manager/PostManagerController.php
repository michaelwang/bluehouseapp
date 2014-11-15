<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Manager;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\PostCommentType;
use Symfony\Component\HttpFoundation\Response;
class PostManagerController extends Controller
{

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
                throw new NotFoundHttpException('Unable to find Post entity.');
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
