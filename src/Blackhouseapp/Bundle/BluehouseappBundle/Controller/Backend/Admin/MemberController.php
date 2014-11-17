<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller\Backend\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blackhouseapp\Bundle\BluehouseappBundle\Controller\Resource\ResourceController;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberType;
use Blackhouseapp\Bundle\BluehouseappBundle\Form\MemberImageType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MemberController  extends ResourceController
{


    /**
     */
    public function listAction(Request $request)
    {
        $repo = $this->getRepository();
        $locked = $request->query->get('locked', 0);

        $results =$repo->queryUserByLockedPaginator($locked);

        $activeCount =$repo->countUserByLocked(false);
        $inactiveCount =$repo->countUserByLocked(true);


        $results->setCurrentPage($request->get('page', 1), true, true);
        $results->setMaxPerPage($this->config->getPaginationMaxPerPage());

        $view = $this
            ->view()
            ->setTemplate($this->config->getTemplate('list.html'))
            ->setData(array(
                'entities'    => $results,
                'activeCount' => $activeCount,
                'inactiveCount' => $inactiveCount
            ))
        ;

        return $this->handleView($view);
    }


    /**
 */
    public function enableAction(Request $request,$id)
    {
        $member =$this->getRepository()
            ->find($id);

       $em = $this->getDoctrine()->getManager();
        $member->setLocked(false);

         $em->flush($member);
        return $this->redirect($this->generateUrl('bluehouseapp_members_list'));
    }

    /**
     */
    public function disableAction(Request $request,$id)
    {
        $member = $this->getRepository()
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $member->setLocked(true);

       $em->flush($member);

        return $this->redirect($this->generateUrl('bluehouseapp_members_list'));
    }


} 