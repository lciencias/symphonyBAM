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
 * Ticket
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class Ticket extends BaseTicket{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_tickets';

    /**
     * Constants Fields
     */
    const ID_TICKET = 'id_ticket';
    const ID_CATEGORY = 'id_category';
    const ID_BASE_TICKET = 'id_base_ticket';
    const ID_EMPLOYEE = 'id_employee';
    const ID_COMPANY = 'id_company';
    const ID_PRIORITY = 'id_priority';
    const ID_IMPACT = 'id_impact';
    const EMAIL   		= 'email';

    /**
     * @var int
     */
    private $idTicket;


    /**
     * @var int
     */
    private $idCategory;


    /**
     * @var int
     */
    private $idBaseTicket;


    /**
     * @var int
     */
    private $idEmployee;


    /**
     * @var int
     */
    private $idCompany;


    /**
     * @var int
     */
    private $idPriority;


    /**
     * @var int
     */
    private $idImpact;

    /**
	 * @var String
	 */
	private $email;
	
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicket();
    }


    /**
     * @return int
     */
    public function getIdTicket(){
        return $this->idTicket;
    }

    /**
     * @param int $idTicket
     * @return Ticket
     */
    public function setIdTicket($idTicket){
        $this->idTicket = $idTicket;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdCategory(){
        return $this->idCategory;
    }

    /**
     * @param int $idCategory
     * @return Ticket
     */
    public function setIdCategory($idCategory){
        $this->idCategory = $idCategory;
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
     * @return Ticket
     */
    public function setIdBaseTicket($idBaseTicket){
        $this->idBaseTicket = $idBaseTicket;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdEmployee(){
        return $this->idEmployee;
    }

    /**
     * @param int $idEmployee
     * @return Ticket
     */
    public function setIdEmployee($idEmployee){
        $this->idEmployee = $idEmployee;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdCompany(){
        return $this->idCompany;
    }

    /**
     * @param int $idCompany
     * @return Ticket
     */
    public function setIdCompany($idCompany){
        $this->idCompany = $idCompany;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdPriority(){
        return $this->idPriority;
    }

    /**
     * @param int $idPriority
     * @return Ticket
     */
    public function setIdPriority($idPriority){
        $this->idPriority = $idPriority;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdImpact(){
        return $this->idImpact;
    }

    /**
     * @param int $idImpact
     * @return Ticket
     */
    public function setIdImpact($idImpact){
        $this->idImpact = $idImpact;
        return $this;
    }


    /**
	 * @return string
	 */	
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @param String $email
	 * @return TicketClient
	 */
	
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_ticket' => $this->getIdTicket(),
            'id_category' => $this->getIdCategory(),
            'id_base_ticket' => $this->getIdBaseTicket(),
            'id_employee' => $this->getIdEmployee(),
            'id_company' => $this->getIdCompany(),
            'id_priority' => $this->getIdPriority(),
            'id_impact' => $this->getIdImpact(),
            'email' => $this->getEmail(),
        );
        return array_merge(parent::toArray(), $array);
    }

}