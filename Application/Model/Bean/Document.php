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
 * Document
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Document extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_documents';

    /**
     * Constants Fields
     */
    const ID_DOCUMENT = 'id_document';
    const NAME = 'name';
    const TYPE = 'type';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idDocument;


    /**
     * @var int
     */
    private $name;


    /**
     * @var int
     */
    private $type;


    /**
     * @var int
     */
    private $status;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdDocument();
    }


    /**
     * @return int
     */
    public function getIdDocument(){
        return $this->idDocument;
    }

    /**
     * @param int $idDocument
     * @return Document
     */
    public function setIdDocument($idDocument){
        $this->idDocument = $idDocument;
        return $this;
    }


    /**
     * @return int
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param int $name
     * @return Document
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param int $type
     * @return Document
     */
    public function setType($type){
        $this->type = $type;
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
     * @return Document
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_document' => $this->getIdDocument(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
        );
        return $array;
    }
    /**
     * 
     * @var array
     */
	public static $Status = array(
			'Active' => 1,
			'Inactive' => 2,
			);
	/**
	 * @return string
	 */
	public function getStatusName(){
		return array_search($this->getStatus(), self::$Status);
	}
	/**
	 *
	 * @return boolean
	 */
	public function isActive(){
		return $this->getStatus() == self::$Status['Active'] ? true : false;
	}
	/**
	 *
	 * @return boolean
	 */
	public function isInactive(){
		return $this->getStatus() == self::$Status['Inactive'] ? true : false;
	}
}