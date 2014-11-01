<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Listener;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Blackhouseapp\Bundle\BluehouseappBundle\Entity\UserBehavior;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class SecurityRegistrationListener implements EventSubscriberInterface
{
    protected $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(UserEvent $event)
    {
        $userBehaviorRepo = $this->em->getRepository('BlackhouseappBluehouseappBundle:UserBehavior');
        $userBehavior = new UserBehavior();
        $userBehavior->setActionName('REGISTRATION_COMPLETED');
        $userBehavior->setUserId($event->getUser()->getId());
        $this->em->persist($userBehavior);
        $this->em->flush();
    }
}