<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 14-10-13
 * Time: 下午2:04
 */

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberType;


class MemberController  extends Controller
{

    /**
     * @Route("/member/edit",name="member_edit")
     * @Template()
     * @Method({"GET"})
     */
    public function editAction(Request $request)
    {
        $param=array('nav_active'=>'nav_active_slacker');
        $current = $this->get('security.context')->getToken()->getUser();
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($current->getId());
        if(!$member->getNickname()){
            $member->setNickname($member->getUsername());
        }
        $isEdit = $member->getAvatar()!='';
        $memberType = new MemberType($isEdit);
        $form = $this->createForm($memberType,$member,array(
            'action'=>$this->generateUrl('member_update'),
            'method'=>'POST'
        ));
        $param['member']=$member;
        $param['form']=$form->createView();
        return $param;
    }

    /**
     * @Route("/member/update",name="member_update")
     * @Template("BlackhouseappBluehouseappBundle:Member:edit.html.twig")
     * @Method({"PUT","POST"})
     */
    public function updateAction(Request $request)
    {
        $current = $this->get('security.context')->getToken()->getUser();
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($current->getId());

        $isEdit = $member->getAvatar()!='';
        $slackerType = new MemberType($isEdit);
        $form = $this->createForm($slackerType,$member,array(
            'action'=>$this->generateUrl('member_update'),
            'method'=>'POST'
        ));
        $form->handleRequest($request);
        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success','保存成功');
            return $this->redirect($this->generateUrl('post',array('id'=>$member->getId())));
        }
        $param['member']=$member;
        $param['form']=$form->createView();
        return $param;


    }
} 