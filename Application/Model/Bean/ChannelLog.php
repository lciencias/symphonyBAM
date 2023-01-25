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
 * ChannelLog
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class ChannelLog extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_channels_logs';

    /**
     * Constants Fields
     */
    const ID_CHANNELS_LOGS = 'id_channels_logs';
    const ID_CHANNEL = 'id_channel';
    const ID_USER = 'id_user';
    const DATE_LOG = 'date_log';
    const EVENT_TYPE = 'event_type';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idChannelsLogs;


    /**
     * @var int
     */
    private $idChannel;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var string
     */
    private $dateLog;

    /**
    * @var int
    */
    private $eventType;

    /**
     * @var \Zend_Date
     */
    private $dateLogAsZendDate;


    /**
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdChannelsLogs();
    }


    /**
     * @return int
     */
    public function getIdChannelsLogs(){
        return $this->idChannelsLogs;
    }

    /**
     * @param int $idChannelsLogs
     * @return ChannelLog
     */
    public function setIdChannelsLogs($idChannelsLogs){
        $this->idChannelsLogs = $idChannelsLogs;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdChannel(){
        return $this->idChannel;
    }

    /**
     * @param int $idChannel
     * @return ChannelLog
     */
    public function setIdChannel($idChannel){
        $this->idChannel = $idChannel;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdUser(){
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return ChannelLog
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }

    /**
    * @return int
    */
    public function getIdEventType(){
    	return $this->eventType;
    }

    /**
     * @param int $idUser
     * @return ChannelLog
     */
    public function setIdEventType($eventType){
    	$this->eventType = $eventType;
    	return $this;
    }


    /**
     * @return string
     */
    public function getDateLog(){
        //return $this->dateLog;
    	return self::format($this->dateLog);
    }

    /**
     * @param string $dateLog
     * @return ChannelLog
     */
    public function setDateLog($dateLog){
        $this->dateLog = $dateLog;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getDateLogAsZendDate(){
        if( null == $this->dateLogAsZendDate ){
            $this->dateLogAsZendDate = new \Zend_Date($this->dateLog, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->dateLogAsZendDate;
    }


    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return ChannelLog
     */
    public function setNote($note){
        $this->note = $note;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_channels_logs' => $this->getIdChannelsLogs(),
            'id_channel' => $this->getIdChannel(),
            'id_user' => $this->getIdUser(),
            'date_log' => $this->getDateLog(),
            'event_type' => $this->getIdEventType(),
            'note' => $this->getNote(),
        );
        return $array;
    }

    /**
     * @return string
     */
    public function getEventTypeName(){
        return array_search($this->getIdEventType(), self::$EventTypes);
    }

    /**
     * @staticvar array
     */
    public static $EventTypes = array(
        'Create' => 1,
        'Update' => 2,
        'Delete' => 3,
        'Reactivate' => 4,
    );

}