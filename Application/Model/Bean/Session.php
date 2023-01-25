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
 * Session
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Session extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_sessions';

    /**
     * Constants Fields
     */
    const ID_SESSION = 'id_session';
    const ID_USER = 'id_user';
    const HASH = 'hash';
    const LAST_REQUEST = 'last_request';

    /**
     * @var int
     */
    private $idSession;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var string
     */
    private $hash;


    /**
     * @var string
     */
    private $lastRequest;

    /**
     * @var \Zend_Date
     */
    private $lastRequestAsZendDate;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdSession();
    }


    /**
     * @return int
     */
    public function getIdSession(){
        return $this->idSession;
    }

    /**
     * @param int $idSession
     * @return Session
     */
    public function setIdSession($idSession){
        $this->idSession = $idSession;
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
     * @return Session
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return string
     */
    public function getHash(){
        return $this->hash;
    }

    /**
     * @param string $hash
     * @return Session
     */
    public function setHash($hash){
        $this->hash = $hash;
        return $this;
    }


    /**
     * @return string
     */
    public function getLastRequest(){
        return $this->lastRequest;
    }

    /**
     * @param string $lastRequest
     * @return Session
     */
    public function setLastRequest($lastRequest){
        $this->lastRequest = $lastRequest;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getLastRequestAsZendDate(){
        if( null == $this->lastRequestAsZendDate ){
            $this->lastRequestAsZendDate = new \Zend_Date($this->lastRequest, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->lastRequestAsZendDate;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_session' => $this->getIdSession(),
            'id_user' => $this->getIdUser(),
            'hash' => $this->getHash(),
            'last_request' => $this->getLastRequest(),
        );
        return $array;
    }

}