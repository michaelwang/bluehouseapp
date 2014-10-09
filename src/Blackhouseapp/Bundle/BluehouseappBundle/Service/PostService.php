<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Service;

use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Post;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\PostComment;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\Member;
class PostService {

    protected $mail;
    protected $em;
    protected $security;
    protected $route;
    protected $req;

    public function __construct($em,$mail,$security,$route,$req)
    {
        $this->mail = $mail;
        $this->em   = $em;
        $this->security = $security;
        $this->route = $route;
        $this->req = $req;
    }

    public function getLastComment($post)
    {
        $commentRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:PostComment');
        $query = $commentRepo->createQueryBuilder('c')
            ->where('c.post = :post')
            ->setParameters(array(':post'=>$post->getId()))
            ->orderBy('c.id','desc')
            ->setMaxResults(1)
            ->setFirstResult(0)
            ->getQuery();
        try {
            $comment = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $comment = null;
        }
        return $comment;
    }

} 