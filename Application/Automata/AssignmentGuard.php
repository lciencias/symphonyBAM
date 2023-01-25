<?php

namespace Application\Automata;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\BaseTicket;

use Automatic\Automatable;
use Application\Model\Bean\Ticket;
use Automatic\AutomataException;
use Automatic\Guard;

/**
 *
 * @author chente
 *
 */
class AssignmentGuard implements Guard
{

    /**
     *
     * @var string
     */
    private $lastError;

    /**
     *
     * @param Automatable $automatable
     * @return boolean
     */
    public function isSafe(Automatable $automatable)
    {
        if( !($automatable instanceof BaseTicket) ){
            $this->lastError = "El objecto no es un Ticket";
            return false;
        }

        if( !$automatable->getIdAssignment() ){
            $this->lastError = "El ticket no tiene un Assignment";
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getLastError(){
       return $this->lastError;
    }

}