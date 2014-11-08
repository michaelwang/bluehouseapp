<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberType;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberImageType;


class MemberController  extends Controller
{


    /**
     * @Route("/admin/members/list/{locked}",name="members_list")
     * @Template()
     * @Method({"GET"})
     */
    public function listAction(Request $request,$locked=0)
    {

        $em = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        $repo = $em->getRepository('BlackhouseappBluehouseappBundle:Member');

        $query = $repo->createQueryBuilder('a')
            ->orderBy('a.modified', 'desc')
            ->where('a.locked = :locked')
            ->setParameters(array('locked' => $locked))
            ->getQuery();

        $entities = $this->get('knp_paginator')->paginate($query, $page, 50);



        $qb = $repo->createQueryBuilder('a');
        $qb->select('COUNT(a)');
        $qb->where('a.locked = :locked');

        $qb->setParameter('locked', false);
        $activeCount = $qb->getQuery()->getSingleScalarResult();

        $qb->setParameter('locked', true);
        $inactiveCount = $qb->getQuery()->getSingleScalarResult();

        return array(
            'entities' => $entities,
            'activeCount' => $activeCount,
              'inactiveCount' => $inactiveCount

        );
    }


    /**
 * @Route("/admin/member/enable/{id}",name="member_enable")
 * @Method({"GET"})
 */
    public function enableAction(Request $request,$id)
    {
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $member->setLocked(false);
        $em->flush($member);
        return $this->redirect($this->generateUrl('members_list'));
    }

    /**
     * @Route("/admin/member/disable/{id}",name="member_disable")
     * @Method({"GET"})
     */
    public function disableAction(Request $request,$id)
    {
        $member = $this->getDoctrine()->getManager()
            ->getRepository('BlackhouseappBluehouseappBundle:Member')
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $member->setLocked(true);
        $em->flush($member);

        return $this->redirect($this->generateUrl('members_list'));
    }


} 