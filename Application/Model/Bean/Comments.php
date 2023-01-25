<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Bean;
	
use Application\Date\PCSDate;

/**
 *
 * Comments
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class Comments extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_comments';

    /**
     * Constants Fields
     */
    const ID_COMMENT = 'id_comment';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_USER_ORIGIN = 'id_user_origin';
    const ID_USER_DESTINY = 'id_user_destiny';
    const CREATION_DATE = 'creation_date';
    const NOTE = 'note';

    /**
     * @var int
     */
    private $idComment;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idUserOrigin;


    /**
     * @var int
     */
    private $idUserDestiny;


    /**
     * @var string
     */
    private $creationDate;

    /**
     * @var \Zend_Date
     */
    private $creationDateAsZendDate;


    /**
     * @var string
     */
    private $note;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdComment();
    }


    /**
     * @return int
     */
    public function getIdComment(){
        return $this->idComment;
    }

    /**
     * @param int $idComment
     * @return Comments
     */
    public function setIdComment($idComment){
		$this->idComment = $idComment;	
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
     * @return Comments
     */
    public function setIdBaseTicket($idBaseTicket){
		$this->idBaseTicket = $idBaseTicket;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdUserOrigin(){
        return $this->idUserOrigin;
    }

    /**
     * @param int $idUserOrigin
     * @return Comments
     */
    public function setIdUserOrigin($idUserOrigin){
		$this->idUserOrigin = $idUserOrigin;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdUserDestiny(){
        return $this->idUserDestiny;
    }

    /**
     * @param int $idUserDestiny
     * @return Comments
     */
    public function setIdUserDestiny($idUserDestiny){
		$this->idUserDestiny = $idUserDestiny;	
        return $this;
    }


    /**
     * @return string
     */
    public function getCreationDate(){
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     * @return Comments
     */
    public function setCreationDate($creationDate){
		$this->creationDate = $creationDate;	
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getCreationDateAsZendDate(){
        if( null == $this->creationDateAsZendDate ){
        	if(!is_null($this->getCreationDate()))
	            $this->creationDateAsZendDate = new PCSDate($this->getCreationDate());
        }
        return $this->creationDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getNote(){
        return $this->note;
    }

    /**
     * @param string $note
     * @return Comments
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
            'id_comment' => $this->getIdComment(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_user_origin' => $this->getIdUserOrigin(),
            'id_user_destiny' => $this->getIdUserDestiny(),
            'creation_date' => $this->getCreationDate(),
            'note' => $this->getNote(),
        );
        return $array;
    }

}
