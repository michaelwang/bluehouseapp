<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     * @Template()
     */
    public function indexAction()
    {

        return  array();

    }

    /**
     * @Route("UAIPBaned")
     * @Template()
     */
    public function banedIPsAction()
    {
        return  array();
    }    

    
    /**
     * @Route("/hi/{name}")
     * @Template()
     */
    public function index1Action($name)
    {


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BlackhouseappBluehouseappBundle:Post')->find(2);



        $data = array(
            'some' => 'data' ,
            'goes' => 'here'
        );
        $jsonp = new JsonResponse($data);
       // $jsonp->setCallback('hi');
        $jsonp->headers->set('Content-Type', 'application/json');
        return $jsonp;
    }



    /*




     */
}
