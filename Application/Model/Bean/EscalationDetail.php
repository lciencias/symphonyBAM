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
 * EscalationDetail
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class EscalationDetail extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_escalation_details';

    /**
     * Constants Fields
     */
    const ID_ESCALATION_DETAILS = 'id_escalation_details';
    const ID_ESCALATION = 'id_escalation';
    const PERCENTAGE = 'percentage';
    const TYPE = 'type';
    const VALUE = 'value';

    /**
     * @var int
     */
    private $idEscalationDetails;


    /**
     * @var int
     */
    private $idEscalation;


    /**
     * @var int
     */
    private $percentage;


    /**
     * @var int
     */
    private $type;


    /**
     * @var string
     */
    private $value;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdEscalationDetails();
    }


    /**
     * @return int
     */
    public function getIdEscalationDetails(){
        return $this->idEscalationDetails;
    }

    /**
     * @param int $idEscalationDetails
     * @return EscalationDetail
     */
    public function setIdEscalationDetails($idEscalationDetails){
        $this->idEscalationDetails = $idEscalationDetails;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdEscalation(){
        return $this->idEscalation;
    }

    /**
     * @param int $idEscalation
     * @return EscalationDetail
     */
    public function setIdEscalation($idEscalation){
        $this->idEscalation = $idEscalation;
        return $this;
    }


    /**
     * @return int
     */
    public function getPercentage(){
        return (int) $this->percentage;
    }

    /**
     * @param int $percentage
     * @return EscalationDetail
     */
    public function setPercentage($percentage){
        $this->percentage = $percentage;
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
     * @return EscalationDetail
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param string $value
     * @return EscalationDetail
     */
    public function setValue($value){
        $this->value = $value;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_escalation_details' => $this->getIdEscalationDetails(),
            'id_escalation' => $this->getIdEscalation(),
            'percentage' => $this->getPercentage(),
            'type' => $this->getType(),
            'value' => $this->getValue(),
        );
        return $array;
    }

    /**
     * @staticvar array
     */
    public static $Types = array(
        'Employee' => 1,
        'Email' => 2,
        'GroupLeader' => 3,
    );

    /**
     *
     * @staticvar array
     */
    public static $TypesLabels = array(
        1 => 'Employee',
        2 => 'Email',
        3 => 'Group Leader',
    );

    /**
     *
     * @return boolean
     */
    public function isEmployeeType(){
        return $this->getType() == self::$Types['Employee'];
    }

    /**
     *
     * @return boolean
     */
    public function isEmailType(){
        return $this->getType() == self::$Types['Email'];
    }

    /**
     *
     * @return boolean
     */
    public function isGroupLeaderType(){
        return $this->getType() == self::$Types['GroupLeader'];
    }

}