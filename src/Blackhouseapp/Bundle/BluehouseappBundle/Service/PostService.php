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
        $query = $commentRepo->createQueryBuilder('pc')
            ->innerJoin('pc.member', 'm')
            ->where('pc.post = :post')
            ->andWhere('m.locked = :mLocked')
            ->andWhere('pc.status = :pcStatus')
            ->andWhere('pc.enabled = :pcEnabled')
            ->setParameters(array(':post'=>$post->getId(),
                'mLocked'=>false,
                'pcStatus' => true, 'pcEnabled' => true,
            ))
            ->orderBy('pc.id','desc')
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

    public function getAllEnableCategories()
    {
        $repo = $this->em->getRepository('BlackhouseappBluehouseappBundle:Category');
        $query = $repo->createQueryBuilder('c')
            ->where('c.enabled = :enabled')
            ->andWhere('c.status = :status')
            ->setParameters(array('enabled' => true,'status'=>true))
            ->orderBy('c.no','desc')
            ->setMaxResults(10)
            ->setFirstResult(0)
            ->getQuery();
        try {
            $categories = $query->getResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $categories = null;
        }
        return $categories;
    }


    public function countPostsByNode($nodeId){
        $node=$this->getNode($nodeId);
        $postRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:Post');

        $qb = $postRepo->createQueryBuilder('p')
        ->select('COUNT(p)')
       ->innerJoin('p.member', 'm')
        ->where('p.node = :node')
        ->andWhere('p.status = :postStatus')
        ->andWhere('p.enabled = :postEnabled')
        ->andWhere('m.locked = :mLocked')
        ->setParameters(array('node'=>$node,'postStatus' => true,
                'postEnabled' => true,
                'mLocked'=>false
            ));
        $count = $qb->getQuery()->getSingleScalarResult();

        return $count;
    }

    public function  getPostsByMember($member){
        $posts = null;
        $postRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:Post');
        $query = $postRepo
            ->createQueryBuilder('p')
            ->innerJoin('p.member', 'm')
            ->innerJoin('p.node', 'n')
            ->innerJoin('n.category', 'c')
            ->where('p.member = :member')
            ->andWhere('m.locked = :mLocked')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('n.status = :nodeStatus')
            ->andWhere('n.enabled = :nodeEnabled')
            ->andWhere('c.status = :cStatus')
            ->andWhere('c.enabled = :cEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array(':member' => $member,
                    'mLocked' => false,
                'postStatus' => true,'postEnabled' => true,
                'nodeStatus'=>true,'nodeEnabled'=>true,
                'cStatus'=>true,'cEnabled'=>true,
                'mLocked'=>false
            ))
           ->orderBy('p.modified', 'desc')
            ->setMaxResults(50)
            ->setFirstResult(0)
            ->getQuery();

        try {
            $posts = $query->getResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $posts = null;
        }

        return $posts;

    }

    public function  getPostCommentsByMember($member){
        $postComments = null;
        $postRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:PostComment');
        $query = $postRepo
            ->createQueryBuilder('pc')
            ->innerJoin('pc.member', 'm')
            ->innerJoin('pc.post', 'p')
            ->innerJoin('p.node', 'n')
            ->innerJoin('n.category', 'c')
            ->where('pc.member = :member')
            ->andWhere('pc.status = :pcStatus')
            ->andWhere('pc.enabled = :pcEnabled')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('n.status = :nodeStatus')
            ->andWhere('n.enabled = :nodeEnabled')
            ->andWhere('c.status = :cStatus')
            ->andWhere('c.enabled = :cEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array(':member' => $member,
                'pcStatus' => true, 'pcEnabled' => true,
                'postStatus' => true,'postEnabled' => true,
                'nodeStatus'=>true,'nodeEnabled'=>true,
                'cStatus'=>true,'cEnabled'=>true,
                'mLocked'=>false
            ))
            ->orderBy('p.modified', 'desc')
            ->setMaxResults(50)
            ->setFirstResult(0)
            ->getQuery();

        try {
            $postComments = $query->getResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $postComments = null;
        }

        return $postComments;

    }

    public function  getPost($postId){
        $post = null;
        $postRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:Post');
        $query = $postRepo
            ->createQueryBuilder('p')
            ->innerJoin('p.member', 'm')
            ->innerJoin('p.node', 'n')
            ->innerJoin('n.category', 'c')
            ->where('p.id = :id')
            ->andWhere('p.status = :postStatus')
            ->andWhere('p.enabled = :postEnabled')
            ->andWhere('n.status = :nodeStatus')
            ->andWhere('n.enabled = :nodeEnabled')
            ->andWhere('c.status = :cStatus')
            ->andWhere('c.enabled = :cEnabled')
            ->andWhere('m.locked = :mLocked')
            ->setParameters(array(':id' => $postId,
                'postStatus' => true,'postEnabled' => true,
                'nodeStatus'=>true,'nodeEnabled'=>true,
                'cStatus'=>true,'cEnabled'=>true,
                'mLocked'=>false
            ))
            ->getQuery();

        try {
            $post = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $post = null;
        }

        return $post;

    }




    public function  getNode($nodeId){
        $repo = $this->em->getRepository('BlackhouseappBluehouseappBundle:Node');

        $query = $repo->createQueryBuilder('n')
            ->where('n.id = :id')
            ->andWhere('n.status = :status')
            ->andWhere('n.enabled = :enabled')
            ->setParameters(array(':id'=>$nodeId,'status'=>true,'enabled'=>true))
            ->orderBy('n.id','desc')
            ->setMaxResults(1)
            ->setFirstResult(0)
            ->getQuery();
        try {
            $node = $query->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $node = null;
        }
        return $node;

    }
} 