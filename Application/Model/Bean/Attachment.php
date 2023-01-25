<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * Attachment
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Attachment extends File{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_attachments';

    /**
     * Constants Fields
     */
    const ID_ATTACHMENT = 'id_attachment';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_FILE = 'id_file';
    const ID_USER = 'id_user';
    const CREATED_AT = 'created_at';

    /**
     * @var int
     */
    private $idAttachment;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idFile;


    /**
     * @var int
     */
    private $idUser;


    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var \Zend_Date
     */
    private $createdAtAsZendDate;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAttachment();
    }


    /**
     * @return int
     */
    public function getIdAttachment(){
        return $this->idAttachment;
    }

    /**
     * @param int $idAttachment
     * @return Attachment
     */
    public function setIdAttachment($idAttachment){
        $this->idAttachment = $idAttachment;
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
     * @return Attachment
     */
    public function setIdFile($idFile){
        $this->idFile = $idFile;
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
     * @return Attachment
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
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
     * @return Attachment
     */
    public function setIdUser($idUser){
        $this->idUser = $idUser;
        return $this;
    }


    /**
     * @return string
     */
    public function getCreatedAt(){
        //return $this->createdAt;
        return self::format($this->createdAt);
    }

    /**
     * @param string $createdAt
     * @return Attachment
     */
    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getCreatedAtAsZendDate(){
        if( null == $this->createdAtAsZendDate ){
            $this->createdAtAsZendDate = new \Zend_Date($this->createdAt, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->createdAtAsZendDate;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_attachment' => $this->getIdAttachment(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_file' => $this->getIdFile(),
            'id_user' => $this->getIdUser(),
            'created_at' => $this->getCreatedAt(),
        );
        return array_merge(parent::toArray(), $array);
    }

}