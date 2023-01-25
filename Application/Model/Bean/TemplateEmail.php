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

namespace Application\Model\Bean;

/**
 *
 * TemplateEmail
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
use Application\Event\EmailEvent;

class TemplateEmail extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_template_emails';

    /**
     * Constants Fields
     */
    const ID_TEMPLATE_EMAIL = 'id_template_email';
    const NAME = 'name';
    const SUBJECT = 'subject';
    const BODY = 'body';
    const EVENT = 'event';
    const STATUS = 'status';
    const TO_EMPLOYEE = 'to_employee';
    const TO_USER = 'to_user';
    const TO_GROUP = 'to_group';
    const LANGUAGE = 'language';
    /**
     * 
     * @var tipo de ticket, si es base ticket, ticket cliente o ticket empleado
     */
    const KIND_OF_TICKET = 'kind_of_ticket';

    /**
     * @var int
     */
    private $idTemplateEmail;

    /**
     * @var string
     */
    private $name;


    /**
     * @var string
     */
    private $subject;


    /**
     * @var string
     */
    private $body;


    /**
     * @var string
     */
    private $event;


    /**
     * @var int
     */
    private $status;


    /**
     * @var boolean
     */
    private $toEmployee;


    /**
     * @var boolean
     */
    private $toUser;


    /**
     * @var boolean
     */
    private $toGroup;

    /**
     *
     * @var string
     */
    private $language;
    
    /**
     * 
     * @var int
     */
	private $kindOfTicket;
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTemplateEmail();
    }


    /**
     * @return int
     */
    public function getIdTemplateEmail(){
        return $this->idTemplateEmail;
    }

    /**
     * @param int $idTemplateEmail
     * @return TemplateEmail
     */
    public function setIdTemplateEmail($idTemplateEmail){
        $this->idTemplateEmail = $idTemplateEmail;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return TemplateEmail
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getSubject(){
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return TemplateEmail
     */
    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }


    /**
     * @return string
     */
    public function getBody(){
        return $this->body;
    }

    /**
     * @param string $body
     * @return TemplateEmail
     */
    public function setBody($body){
        $this->body = $body;
        return $this;
    }


    /**
     * @return string
     */
    public function getEvent(){
        return $this->event;
    }

    /**
     *
     * @return string
     */
    public function getEventName(){
        $events = EmailEvent::getEvents() + EmailEvent::getTicketClientEvents();
        return isset($events[$this->getEvent()]) ? $events[$this->getEvent()] : '';
    }

    /**
     * @param string $event
     * @return TemplateEmail
     */
    public function setEvent($event){
        $this->event = $event;
        return $this;
    }


    /**
     * @return int
     */
    public function getStatus(){
        return $this->status;
    }

    /**
     * @param int $status
     * @return TemplateEmail
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getToEmployee(){
        return $this->toEmployee;
    }

    /**
     * @param boolean $toEmployee
     * @return TemplateEmail
     */
    public function setToEmployee($toEmployee){
        $this->toEmployee = $toEmployee;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getToUser(){
        return $this->toUser;
    }

    /**
     * @param boolean $toUser
     * @return TemplateEmail
     */
    public function setToUser($toUser){
        $this->toUser = $toUser;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getToGroup(){
        return $this->toGroup;
    }

    /**
     * @param boolean $toGroup
     * @return TemplateEmail
     */
    public function setToGroup($toGroup){
        $this->toGroup = $toGroup;
        return $this;
    }

    /**
     *
     * @param string $language
     */
    public function setLanguage($language){
        $this->language = $language;
    }

    /**
     * @return string
     */
    public function getLanguage(){
        return $this->language;
    }

    /**
     *
     * @param string $kindOfTicket
     */
    public function setKindOfTicket($kindOfTicket){
    	$this->kindOfTicket = $kindOfTicket;
    }
    
    /**
     * @return string
     */
    public function getKindOfTicket(){
    	return $this->kindOfTicket;
    }
    
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
        		'id_template_email' => $this->getIdTemplateEmail(),
        		'name' => $this->getName(),
        		'subject' => $this->getSubject(),
        		'body' => $this->getBody(),
        		'event' => $this->getEvent(),
        		'status' => $this->getStatus(),
        		'to_employee' => $this->getToEmployee(),
        		'to_user' => $this->getToUser(),
        		'to_group' => $this->getToGroup(),
        		'language' => $this->getLanguage(),
        		'kind_of_ticket' => $this->getKindOfTicket(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getStatusName(){
        return array_search($this->getStatus(), self::$Status);
    }

    /**
     * @return string
     */
    public function getLanguageName(){
        return array_search($this->getLanguage(), Person::$Languages);
    }

    /**
     * @staticvar array
     */
    public static $Status = array(
        'Active' => 1,
        'Inactive' => 2,
    );

    /**
     * @return boolean
     */
    public function isActive(){
        return $this->getStatus() == self::$Status['Active'];
    }

    /**
     * @return boolean
     */
    public function isInactive(){
        return $this->getStatus() == self::$Status['Inactive'];
    }
    /**
     * 
     * @var array
     */
	public static $KindOfTicket = array(
			'Todos los tickets' => 1,
			'Ticket Empleado' => 2,
			'Ticket Cliente' => 3,
			);
}