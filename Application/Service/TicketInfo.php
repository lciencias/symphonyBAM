<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Service;

use Application\Model\Bean\User;

use Application\Query\BranchQuery;

use Application\Model\Bean\Area;

use Application\Model\Bean\Location;

use Application\Model\Bean\ClientCategory;

use Application\Query\ClientCategoryQuery;

use Application\Model\Bean\Impact;

use Application\Model\Bean\Priority;

use Application\Model\Bean\Category;

use Application\Model\Bean\Company;

use Application\Model\Bean\Employee;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\Branch;

use Application\Model\Bean\BaseTicket;

use Application\Query\AreaQuery;

use Application\Query\LocationQuery;

use Application\Query\AssignmentQuery;
use Application\Query\GroupQuery;
use Application\Query\UserQuery;
use Application\Query\TicketTypeQuery;
use Application\Query\ChannelQuery;
use Application\Query\ImpactQuery;
use Application\Query\PriorityQuery;
use Application\Query\CategoryQuery;
use Application\Query\CompanyQuery;
use Application\Query\EmployeeQuery;
use Application\Model\Bean\AbstractBean;
use Application\Model\Bean\Ticket;

/**
 *
 * TicketInfo
 *
 * @category Application\Info
 * @author guadalupe, chente
 */
class TicketInfo
{

    /**
     *
     * @var array
     */
    private $objects;

    /**
     *
     * @var string
     */
    private $escaper = '%';

    /**
     *
     * @param Ticket $ticket
     * @return \Application\Service\TicketInfo
     */
    public static function factory(BaseTicket $ticket)
    {
        $info = new TicketInfo();
        if ($ticket instanceof Ticket){
        	$employee = EmployeeQuery::create()->findByPKOrThrow($ticket->getIdEmployee(), "The employee not exists");
        	$company = CompanyQuery::create()->findByPKOrThrow($ticket->getIdCompany(), "The company not exists");
        	$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The category not exists");
        	
        	$priority = $ticket->getIdPriority() ? PriorityQuery::create()->findByPK($ticket->getIdPriority()) : new Priority();
        	$impact = $ticket->getIdImpact() ? ImpactQuery::create()->findByPK($ticket->getIdImpact()):new Impact();
        	$channel = ChannelQuery::create()->findByPKOrThrow($ticket->getIdChannel(), "The channel not exists");
        	$ticketType = TicketTypeQuery::create()->findByPKOrThrow($ticket->getIdTicketType(), "The ticket type not exists");
        	$user = UserQuery::create()->findByPKOrThrow($ticket->getIdUser(), "The user not exists");
        	$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exists");
        	$location = LocationQuery::create()->findByPKOrThrow($employee->getIdLocation(), "The location not exists");
        	$area = AreaQuery::create()->findByPKOrThrow($employee->getIdArea(), "The area not exists");
        	$originBranch = new Branch();
        	$reportedBranch = new Branch();
        }else if($ticket instanceof TicketClient){
        	$company = new Company();
        	$category = ClientCategoryQuery::create()->findByPKOrElse($ticket->getIdClientCategory(), new ClientCategory());
        	$priority = new Priority();
        	$impact = new Impact();
        	$channel = ChannelQuery::create()->findByPKOrThrow($ticket->getIdChannel(), "The channel not exists");
        	$ticketType = TicketTypeQuery::create()->findByPKOrThrow($ticket->getIdTicketType(), "The ticket type not exists");
        	$user = UserQuery::create()->findByPKOrThrow($ticket->getIdUser(), "The user not exists");
        	$employee = EmployeeQuery::create()->findByPK($user->getIdEmployee());
        	$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exists");
        	$location = new Location();
        	$area = new Area();
        	$originBranch = BranchQuery::create()->findByPK($ticket->getIdOriginBranch());
        	$reportedBranch = BranchQuery::create()->findByPK($ticket->getIdReportedBranch());
        }
        
        $info->set('origin_branch', $originBranch);
        $info->set('origin_reported', $reportedBranch);
        $info->set('ticket', $ticket);
        $info->set('employee', $employee);
        $info->set('company', $company);
        $info->set('category', $category);
        $info->set('priority', $priority);
        $info->set('impact', $impact);
        $info->set('channel', $channel);
        $info->set('ticket_type', $ticketType);
        $info->set('user', $user);
        $info->set('group', $group);
        $info->set('area', $area);
        $info->set('location', $location);


        if( $ticket->getIdAssignment() ){
            $assignment = AssignmentQuery::create()->findByPKOrThrow($ticket->getIdAssignment(), "The assignment not exists");
            $info->set('assignment', $assignment);

            $assignedUser = UserQuery::create()->findByPKOrThrow($assignment->getIdUser(), "The user not exists");
            $info->set('assignedUser', $assignedUser);
        }else{
        	$info->set('assignedUser', new User());
        }
        return $info;
    }

    /**
     *
     */
    public function toArray($escaper = '%')
    {
        $this->escaper = $escaper;
        $variables = $this->objectToArray('ticket');
        $variables = array_merge($variables, $this->objectToArray('employee'));
        $variables = array_merge($variables, $this->objectToArray('category'));
        $variables = array_merge($variables, $this->objectToArray('group'));
        $variables = array_merge($variables, $this->objectToArray('company'));
        $variables = array_merge($variables, $this->objectToArray('priority'));
        $variables = array_merge($variables, $this->objectToArray('impact'));
        $variables = array_merge($variables, $this->objectToArray('channel'));
        $variables = array_merge($variables, $this->objectToArray('ticket_type'));
        $variables = array_merge($variables, $this->objectToArray('user'));
        $variables = array_merge($variables, $this->objectToArray('area'));
        $variables = array_merge($variables, $this->objectToArray('location'));
        if( $this->has('assignedUser') ){
            $variables = array_merge($variables, $this->objectToArray('assignedUser'));
        }
        return $variables;
    }

    /**
     *
     * @param unknown_type $object
     * @param unknown_type $default
     * @return AbstractBean
     */
    public function get($object, $default = null){
        return isset($this->objects[$object]) ? $this->objects[$object] : $default;
    }

    /**
     *
     * @param unknown_type $object
     * @param unknown_type $default
     * @return AbstractBean
     */
    public function set($objectName, AbstractBean $object){
        $this->objects[$objectName] = $object;
    }

    /**
     *
     * @param string $object
     * @return boolean
     */
    public function has($object){
        return isset($this->objects[$object]);
    }

    /**
     *
     * @param unknown_type $objectName
     * @return array
     */
    private function objectToArray($objectName){
        return $this->toVars($objectName . '.', $this->get($objectName)->toArray());
    }

    /**
     *
     * @param unknown_type $prefix
     * @param unknown_type $array
     * @return array
     */
    private function toVars($prefix, $array){
        $newArray = array();
        foreach( $array as $key => $value ){
            $escaper = $this->escaper;
            $newKey = $escaper . $prefix . $key . $escaper;
            $newArray[$newKey] = $value;
        }
        return $newArray;
    }

}