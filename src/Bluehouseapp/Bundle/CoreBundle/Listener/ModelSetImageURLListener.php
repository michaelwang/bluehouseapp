<?php
/**
 * Created by PhpStorm.
 * User: John
 * Date: 14-12-23
 * Time: 下午4:41
 */

namespace Bluehouseapp\Bundle\CoreBundle\Listener;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Bluehouseapp\Bundle\CoreBundle\Entity\Member;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
class ModelSetImageURLListener implements EventSubscriber{

    private $helper;
    public function __construct(UploaderHelper $helper)
    {
        $this->helper = $helper;
    }

    public function getSubscribedEvents()
    {
        return array(
            'postLoad'
        );
    }
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ( $entity instanceof Member) {

            $accessor = PropertyAccess::createPropertyAccessor();

            $userImage=$accessor->getValue($entity, 'userImage');
            if($userImage!=null){
                $path = $this->helper->asset($entity, 'userImage');
                if($path!=null)
                    $entity->setUserImageURL($path);
            }

        }
    }

} 