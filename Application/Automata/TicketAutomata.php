<?php

namespace Application\Automata;

use Application\Model\Bean\Ticket;

use Application\Storage\File;
use Automatic\Transition;
use Application\Query\MachineQuery;
use Application\Query\ConditionQuery;
use Application\Query\StateQuery;
use Application\Query\ElementQuery;
use Automatic\TransitionCollection;
use Application\Model\Catalog\ElementCatalog;
use Application\Model\Bean\Machine as MachineBean;
use Application\Model\Catalog\StateCatalog;
use Application\Model\Catalog\ConditionCatalog;
use Application\Model\Catalog\MachineCatalog;
use Automatic\Machine;

/**
 *
 * @author chente
 *
 */
class TicketAutomata
{


    /**
     *
     * @var StateCatalog
     */
    private $stateCatalog;

    /**
     *
     * @var ConditionCatalog
     */
    private $conditionCatalog;

    /**
     *
     * @var MachineCatalog
     */
    private $machineCatalog;

    /**
     *
     * @var ElementCatalog
     */
    private $elementCatalog;

    /**
     *
     * @var Machine
     */
    private $machine;

    /**
     *
     * @var array
     */
    private $defaultGuards = array();

    /**
     *
     */
    public function __construct(StateCatalog $stateCatalog, ConditionCatalog $conditionCatalog,
    MachineCatalog $machineCatalog, ElementCatalog $elementCatalog){
        $this->stateCatalog = $stateCatalog;
        $this->conditionCatalog = $conditionCatalog;
        $this->machineCatalog = $machineCatalog;
        $this->elementCatalog = $elementCatalog;
    }


    /**
     * @return Machine
     */
    public function getMachine()
    {
        if( null == $this->machine ){

            $storage = $this->getCache();
            if( $storage->exists('TicketAutomata') ){
                $this->machine = $storage->load('TicketAutomata');
            }else{
                $this->defaultGuards[] = new StoppedGuard();
                $this->machine = new Machine($this->getTransitions(), new TicketHandler());
                $storage->save('TicketAutomata', $this->machine);
            }
        }
        return $this->machine;
    }

    /**
     * @return Storage
     */
    private function getCache(){
        return new File( array(
            'lifetime' => 864000,
            'automatic_serialization' => true,
        ), array(
            'cache_dir' => 'cache/automata',
        ));
    }

    /**
     *
     */
    private function getTransitions()
    {
        $transitions = new TransitionCollection();
        $element = ElementQuery::create()->whereAdd('name', 'ticket')
            ->findOneOrThrow("No existe el elemento");

        $states = StateQuery::create()->whereAdd('id_element', $element->getIdElement())->find();
        $conditions = ConditionQuery::create()->whereAdd('id_element', $element->getIdElement())->find();

        $self = $this;
        $transitions->appendFromArray(MachineQuery::create()
            ->whereAdd('id_element', $element->getIdElement())
            ->find()
            ->map(function (MachineBean $bean) use($states, $conditions, $self){
                $currentState = $states->getByPK($bean->getIdAutomataState());
                $nextState = $states->getByPK($bean->getNextState());
                $condition = $conditions->getByPK($bean->getIdAutomataCondition());
                $guards = $self->getGuards($currentState, $nextState, $condition);
                return new Transition($currentState, $condition, $nextState, $guards);
            }));
        return $transitions;
    }

    /**
     *
     * @param mixed $currentState
     * @param mixed $nextState
     * @param mixed $condition
     * @return array
     */
    public function getGuards($currentState, $nextState, $condition){
        $guards = array();

        if( $nextState->getName() == 'Assigned' ){
            $guards[] = new AssignmentGuard();
        }

        return array_merge($this->defaultGuards, $guards);
    }

}