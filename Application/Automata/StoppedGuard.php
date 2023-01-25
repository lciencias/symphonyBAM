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
class StoppedGuard implements Guard
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

        if( $automatable->getIsStopped() ){
            $this->lastError = "El ticket esta pausado, es necesario despausar antes de aplicar cualquier cambio";
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