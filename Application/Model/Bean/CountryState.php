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
 * CountryState
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class CountryState extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_country_states';

    /**
     * Constants Fields
     */
    const ID_COUNTRY_STATE = 'id_country_state';
    const NAME = 'name';
    const TYPE = 'type';
    const STATUS = 'status';

    /**
     * @var int
     */
    private $idCountryState;


    /**
     * @var string
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
        return $this->getIdCountryState();
    }


    /**
     * @return int
     */
    public function getIdCountryState(){
        return $this->idCountryState;
    }

    /**
     * @param int $idCountryState
     * @return CountryState
     */
    public function setIdCountryState($idCountryState){
        $this->idCountryState = $idCountryState;
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
     * @return CountryState
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
     * @return CountryState
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
     * @return CountryState
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
	/**
	 * 
	 * @var array
	 */
	public static $Statuses = array(
			'Active' => 1,
			'Inactive' => 2,
			);
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_country_state' => $this->getIdCountryState(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'status' => $this->getStatus(),
        );
        return $array;
    }

}