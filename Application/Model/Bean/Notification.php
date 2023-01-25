<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * Notification
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Notification extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_notifications';

    /**
     * Constants Fields
     */
    const ID_NOTIFICATION = 'id_notification';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_TEMPLATE_EMAIL = 'id_template_email';
    const TO = 'to';
    const DISPATCHED = 'dispatched';
    const CREATED = 'created';
    const CC = 'cc';
    const BCC = 'bcc';
    const ID_FILE = 'id_file';

    /**
     * @var int
     */
    private $idNotification;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idTemplateEmail;


    /**
     * @var string
     */
    private $to;


    /**
     * @var boolean
     */
    private $dispatched;


    /**
     * @var string
     */
    private $created;

    /**
     * @var \Zend_Date
     */
    private $createdAsZendDate;


    /**
     * @var string
     */
    private $cc;


    /**
     * @var string
     */
    private $bcc;


    /**
     * @var int
     */
    private $idFile;
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdNotification();
    }


    /**
     * @return int
     */
    public function getIdNotification(){
        return $this->idNotification;
    }

    /**
     * @param int $idNotification
     * @return Notification
     */
    public function setIdNotification($idNotification){
        $this->idNotification = $idNotification;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdBaseTicket(){
        return $this->idBaseTicket;
    }

    /**
     * @param int $idBaseTicket
     * @return Notification
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTemplateEmail(){
        return $this->idTemplateEmail;
    }

    /**
     * @param int $idTemplateEmail
     * @return Notification
     */
    public function setIdTemplateEmail($idTemplateEmail){
        $this->idTemplateEmail = $idTemplateEmail;
        return $this;
    }


    /**
     * @return string
     */
    public function getTo(){
        return $this->to;
    }

    /**
     * @param string $to
     * @return Notification
     */
    public function setTo($to){
        $this->to = $to;
        return $this;
    }


    /**
     * @return boolean
     */
    public function getDispatched(){
        return $this->dispatched;
    }

    /**
     * @param boolean $dispatched
     * @return Notification
     */
    public function setDispatched($dispatched){
        $this->dispatched = $dispatched;
        return $this;
    }


    /**
     * @return string
     */
    public function getCreated(){
        return $this->created;
    }

    /**
     * @param string $created
     * @return Notification
     */
    public function setCreated($created){
        $this->created = $created;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getCreatedAsZendDate(){
        if( null == $this->createdAsZendDate ){
            $this->createdAsZendDate = new \Zend_Date($this->created, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->createdAsZendDate;
    }


    /**
     * @return string
     */
    public function getCc(){
        return $this->cc;
    }

    /**
     * @param string $cc
     * @return Notification
     */
    public function setCc($cc){
        $this->cc = $cc;
        return $this;
    }


    /**
     * @return string
     */
    public function getBcc(){
        return $this->bcc;
    }

    /**
     * @param string $bcc
     * @return Notification
     */
    public function setBcc($bcc){
        $this->bcc = $bcc;
        return $this;
    }

    /**
     * @return int
     */
    public function getIdFile(){
    	return $this->idFile;
    }
    
    /**
     * @param int $idFile
     * @return Notification
     */
    public function setIdFile($idFile){
    	$this->idFile = $idFile;
    	return $this;
    }
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_notification' => $this->getIdNotification(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_template_email' => $this->getIdTemplateEmail(),
            'to' => $this->getTo(),
            'dispatched' => $this->getDispatched(),
            'created' => $this->getCreated(),
            'cc' => $this->getCc(),
            'bcc' => $this->getBcc(),
        	'id_file' => $this->getIdFile(),
        );
        return $array;
    }

}