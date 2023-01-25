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

/**
 *
 * ControversyIssues
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class ControversyIssues extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_controversy_issues';

    /**
     * Constants Fields
     */
    const ID_CONTROVERSY_ISSUE = 'id_controversy_issue';
    const ID_CONTROVERSY_REASON = 'id_controversy_reason';
    const NAME = 'name';
    const TYPE = 'type';

    /**
     * @var int
     */
    private $idControversyIssue;


    /**
     * @var int
     */
    private $idControversyReason;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $type;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdControversyIssue();
    }


    /**
     * @return int
     */
    public function getIdControversyIssue(){
        return $this->idControversyIssue;
    }

    /**
     * @param int $idControversyIssue
     * @return ControversyIssues
     */
    public function setIdControversyIssue($idControversyIssue){
		$this->idControversyIssue = $idControversyIssue;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdControversyReason(){
        return $this->idControversyReason;
    }

    /**
     * @param int $idControversyReason
     * @return ControversyIssues
     */
    public function setIdControversyReason($idControversyReason){
		$this->idControversyReason = $idControversyReason;	
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
     * @return ControversyIssues
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
     * @return ControversyIssues
     */
    public function setType($type){
		$this->type = $type;	
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_controversy_issue' => $this->getIdControversyIssue(),
            'id_controversy_reason' => $this->getIdControversyReason(),
            'name' => $this->getName(),
            'type' => $this->getType(),
        );
        return $array;
    }

}
