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
 * ClientData
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientData extends AbstractBean{

	/**
	 * TABLENAME
	 */
	const TABLENAME = 'pcs_symphony_client_data';

	/**
	 * Constants Fields
	 */
	const CLIENT_NUMBER = 'client_number';
	const NAME = 'name';
	const RFC = 'rfc';
	const BIRTHDAY = 'birthday';
	const HOME_PHONE = 'home_phone';
	const OFFICE_PHONE = 'office_phone';
	const MOBILE_PHONE = 'mobile_phone';
	const STREET = 'street';
	const EXTERNAL_NUMBER = 'external_number';
	const INTERNAL_NUMBER = 'internal_number';
	const STATE = 'state';
	const TOWN = 'town';
	const COLONY = 'colony';
	const ZIP_CODE = 'zip_code';
	const ID_BRANCH = 'id_branch';
	const EMAIL = 'email';
	const EMPLOYEE = 'employee';
	const CARD_TYPE = 'card_type';
	const ID_ENTIDAD = 'id_entidad';
	

	/**
	 * @var string
	 */
	private $clientNumber;


	/**
	 * @var string
	 */
	private $name;


	/**
	 * @var string
	 */
	private $rfc;


	/**
	 * @var string
	 */
	private $birthday;

	/**
	 *
	 * @var \Zend_Date
	 */
	private $birthdayAsZendDate;
	/**
	 * @var string
	 */
	private $homePhone;


	/**
	 * @var string
	 */
	private $officePhone;


	/**
	 * @var string
	 */
	private $mobilePhone;


	/**
	 * @var string
	 */
	private $street;


	/**
	 * @var string
	 */
	private $externalNumber;


	/**
	 * @var string
	 */
	private $internalNumber;


	/**
	 * @var string
	 */
	private $state;


	/**
	 * @var string
	 */
	private $town;


	/**
	 * @var string
	 */
	private $colony;


	/**
	 * @var string
	 */
	private $zipCode;

	/**
	 * @var string
	 */
	private $idBranch;

	/**
	 * @var string
	 */
	private $email;
	
	/**
	 * @var string
	 */
	private $employee;
	
	/**
	 * @var string
	 */
	private $cardType;
	
	/**
	 * @var string
	 */
	private $idEntidad;
	
	public function getIndex(){
		return rand(1, 100000);
	}
	/**
	 * @return string
	 */
	public function getClientNumber(){
		return $this->clientNumber;
	}

	/**
	 * @param string $clientNumber
	 * @return ClientData
	 */
	public function setClientNumber($clientNumber){
		$this->clientNumber = $clientNumber;
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
	 * @return ClientData
	 */
	public function setName($name){
		$this->name = $name;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getRfc(){
		return $this->rfc;
	}

	/**
	 * @param string $rfc
	 * @return ClientData
	 */
	public function setRfc($rfc){
		$this->rfc = $rfc;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getBirthday(){
		return $this->birthday;
	}

	/**
	 * @param string $birthday
	 * @return ClientData
	 */
	public function setBirthday($birthday){
		$this->birthday = $birthday;
		return $this;
	}

	/**
	 * @return \Zend_Date
	 */
	public function getBirthdayAsZendDate(){
		if( null == $this->birthdayAsZendDate ){
			$this->birthdayAsZendDate = new \Zend_Date($this->birthday, 'yyyy-MM-dd');
		}
		return $this->birthdayAsZendDate;
	}

	/**
	 * @return string
	 */
	public function getHomePhone(){
		return $this->homePhone;
	}

	/**
	 * @param string $homePhone
	 * @return ClientData
	 */
	public function setHomePhone($homePhone){
		$this->homePhone = $homePhone;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getOfficePhone(){
		return $this->officePhone;
	}

	/**
	 * @param string $officePhone
	 * @return ClientData
	 */
	public function setOfficePhone($officePhone){
		$this->officePhone = $officePhone;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getMobilePhone(){
		return $this->mobilePhone;
	}

	/**
	 * @param string $mobilePhone
	 * @return ClientData
	 */
	public function setMobilePhone($mobilePhone){
		$this->mobilePhone = $mobilePhone;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getStreet(){
		return $this->street;
	}

	/**
	 * @param string $street
	 * @return ClientData
	 */
	public function setStreet($street){
		$this->street = $street;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getExternalNumber(){
		return $this->externalNumber;
	}

	/**
	 * @param string $externalNumber
	 * @return ClientData
	 */
	public function setExternalNumber($externalNumber){
		$this->externalNumber = $externalNumber;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getInternalNumber(){
		return $this->internalNumber;
	}

	/**
	 * @param string $internalNumber
	 * @return ClientData
	 */
	public function setInternalNumber($internalNumber){
		$this->internalNumber = $internalNumber;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getState(){
		return $this->state;
	}

	/**
	 * @param string $state
	 * @return ClientData
	 */
	public function setState($state){
		$this->state = $state;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getTown(){
		return $this->town;
	}

	/**
	 * @param string $town
	 * @return ClientData
	 */
	public function setTown($town){
		$this->town = $town;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getColony(){
		return $this->colony;
	}

	/**
	 * @param string $colony
	 * @return ClientData
	 */
	public function setColony($colony){
		$this->colony = $colony;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getZipCode(){
		return $this->zipCode;
	}

	/**
	 * @param string $zipCode
	 * @return ClientData
	 */
	public function setZipCode($zipCode){
		$this->zipCode = $zipCode;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getIdBranch(){
		return $this->idBranch;
	}
	
	/**
	 * @param int $idBranch
	 * @return ClientData
	 */
	public function setIdBranch($idBranch){
		$this->idBranch = $idBranch;
		return $this;
	}

	/**
	 * @return String
	 */
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 * @param String $email
	 * @return ClientData
	 */
	public function setEmail($email){
		$this->email = $email;
		return $this;
	}
	

	/**
	 * @return string
	 */
	public function getEmployee() {
		return $this->employee;
	}
	
	/**
	 * @param String $employee
	 * @return TicketClient
	 */
	
	public function setEmployee($employee) {
		$this->employee = $employee;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getCardType() {
		return $this->cardType;
	}
	
	/**
	 * @param String $cardType
	 * @return TicketClient
	 */
	
	public function setCardType($cardType) {
		$this->cardType = $cardType;
		return $this;
	}
	
	
	/**
	 * @return string
	 */
	public function getIdEntidad() {
		return $this->idEntidad;
	}
	
	/**
	 * @param String $idEntidad
	 * @return TicketClient
	 */
	
	public function setIdEntidad($idEntidad) {
		$this->idEntidad = $idEntidad;
		return $this;
	}
	
	
	/**
	 * Convert to array
	 * @return array
	 */
	public function toArray()
	{
		$array = array(
				'client_number' => $this->getClientNumber(),
				'name' => $this->getName(),
				'rfc' => $this->getRfc(),
				'birthday' => $this->getBirthday(),
				'home_phone' => $this->getHomePhone(),
				'office_phone' => $this->getOfficePhone(),
				'mobile_phone' => $this->getMobilePhone(),
				'street' => $this->getStreet(),
				'external_number' => $this->getExternalNumber(),
				'internal_number' => $this->getInternalNumber(),
				'state' => $this->getState(),
				'town' => $this->getTown(),
				'colony' => $this->getColony(),
				'zip_code' => $this->getZipCode(),
				'id_branch' => $this->getIdBranch(),
				'email' => $this->getEmail(),
				'employee' => $this->getEmployee(),
				'card_type' => $this->getCardType(),
				'id_entidad' => $this->getIdEntidad(),
		);
		return $array;
	}

}