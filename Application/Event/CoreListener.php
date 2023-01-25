<?php

namespace Application\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 *
 * @author chente
 *
 */
class CoreListener implements EventSubscriberInterface
{

    /**
     *
     * @return array
     */
    public static function getSubscribedEvents(){
        return array(
            CoreEvent::BOOTSTRAP_REGISTER_CORE_LISTENER => 'loadSubscribers',
        );
    }

    /**
     * @param CoreEvent $event
     */
    public function loadSubscribers(CoreEvent $event){
        $eventDispatcher = $event->get('eventDispatcher');
        $eventDispatcher->addSubscriber(new EmailListener());
    }

}