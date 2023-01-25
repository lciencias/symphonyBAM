<?php

namespace Application\Automata;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\BaseTicket;

use Application\Event\EmailEvent;
use Application\Model\Bean\TicketLog;
use Application\Model\Bean\User;
use Application\Model\Factory\TicketLogFactory;
use Application\Event\CoreEvent;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Automatic\AutomataException;
use Application\Model\Bean\Ticket;
use Automatic\Transition;
use Automatic\Automatable;
use Automatic\Handler;

/**
 *
 * @author chente
 *
 */
class TicketHandler implements Handler
{

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    private function getEventDispatcher(){
        return \Zend_Registry::get('container')->get('event_dispatcher');
    }

    /**
     *
     * @param Automatable $automatable
     * @param Transition $transition
     * @param array $variables
     */
    public function apply(Automatable $automatable, Transition $transition, $variables = array())
    {
        $ticket = $automatable;
        $user = $variables['user'];
        if( !$ticket instanceof BaseTicket ){
            throw new AutomataException("El objecto no puede pasar por el automata para Tickets");
        }
        if( !$user instanceof User){
            throw new AutomataException("Falta definir el usuario");
        }
        $ticketCatalog = $this->getCatalog('BaseTicketCatalog');
        $now = new \Zend_Date();
        $oldStatus = $ticket->getStatus();
        $newStatus = $transition->getNextState()->getKey();

        try
        {
            $ticketCatalog->beginTransaction();

            $ticket->setStatus($newStatus);
            $ticketCatalog->update($ticket);

            $ticketLog = TicketLogFactory::createFromArray(array(
                'id_base_ticket' => $ticket->getIdBaseTicket(),
                'id_user' => $user->getIdUser(),
                'date_log' => $variables['date_log'] ?: $now->get('yyyy-MM-dd HH:mm:ss'),
                'event_type' => TicketLog::$EventTypes['Status'],
                'changed_from' => $oldStatus,
                'changed_to' => $newStatus,
                'note' => $variables['note'] ?: '',
            ));
            $this->getCatalog('TicketLogCatalog')->create($ticketLog);

            $event = new EmailEvent(array_merge(array(
                'ticket' => $ticket,
                'transition' => $transition,
            ), $variables));
            $this->getEventDispatcher()->dispatch(EmailEvent::TICKET_CHANGE_STATUS, $event);

            $ticketCatalog->commit();
        }
        catch (\Exception $e) {
            $ticketCatalog->rollBack();
            throw $e;
        }
    }

    /**
     *
     * @param unknown_type $catalog
     * @return \Application\Model\Catalog\Catalog
     */
    public function getCatalog($catalog){
        return \Zend_Registry::get('container')->get($catalog);
    }

}