<?php
/**
 * PCS Mexico
 *
 * SOCHI
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   1
 */

namespace Application\Model\Bean;

/**
 *
 * TicketClient
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
use Application\Query\ClientCategoryQuery;

use Application\Query\BranchQuery;

use Application\Query\CategoryQuery;

class TicketClient extends BaseTicket{

	/**
	 * TABLENAME
	 */
	const TABLENAME = 'pcs_symphony_tickets_clients';

	/**
	 * Constants Fields
	 */
	const ID_TICKET_CLIENT = 'id_ticket_client';
	const ID_BASE_TICKET = 'id_base_ticket';
	const FOLIO = 'folio';
	const ACCOUNT_NUMBER = 'account_number';
	const ID_ORIGIN_BRANCH = 'id_origin_branch';
	const ID_REPORTED_BRANCH = 'id_reported_branch';
	const ID_CLIENT_CATEGORY = 'id_client_category';	
	const ID_PRODUCT = 'id_product';
	const STATE_CLIENT  = 'state_client';
	const EMAIL   		= 'email';
	const FOLIO_PREV = 'folio_prev';
	const CLIENT_NUMBER = 'client_number';
	const ID_USER_LAST_ASSIGN = 'id_user_last_assign';
	const NAME_CLIENT = 'name_client';
	const NO_CARD = 'no_card';
	const EMPLOYEE = 'employee';
	const CARD_TYPE = 'card_type'; 
	const EXPIRATION_DATE = 'expiration_date';
	const CHANEL = 'chanel';
	const FOLIO_CONDUSEF = 'folio_condusef';
	const ID_RESOLVER = 'id_resolver';
	const ACCOUNT_TYPE = 'account_type';
	const TELEFONO = 'telefono';
	const ID_ENTIDAD = 'id_entidad';
	const COMPLAINT = 'complaint';
	/**
	 * @var int
	 */
	private $idTicketClient;


	/**
	 * @var int
	 */
	private $idBaseTicket;


	/**
	 * @var string
	 */
	private $folio;

	/**
	 * @var int
	 */
	private $idClientCategory;
	
	/**
	 * @var string
	 */
	private $accountNumber;


	/**
	 * @var int
	 */
	private $idOriginBranch;


	/**
	 * @var int
	 */
	private $idReportedBranch;


	/**
	 * @var int
	 */
	private $idProduct;
	
	
	/**
	 * @var String
	 */
	private $email;
	
	/**
	 * @var String
	 */
	private $folioPrev;

	/**
	 * @var double
	 */
	private $clientNumber;
	
	/**
	 * @var int
	 */
	private $idUserLastAssign;
	
	/**
	 * @var String
	 */
	private $stateClient;

	/**
	 * @var string
	 */
	private $nameClient;

	/**
	 * @var string
	 */
	private $noCard;
	
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
	private $expirationDate;
	
	/**
	 * @var string
	 */
	private $chanel;
	
	/**
	 * @var string
	 */
	private $folioCondusef;
	
	
	/**
	 * @var int
	 */
	private $idResolver;
	
	/**
	 * @var string
	 */
	private $accountType;

	/**
	 * @var string
	 */
	private $telefono;
	
	/**
	 * @var int
	 */
	private $idEntidad;
	
	/**
	 * @var int
	 */
	private $complaint;	
	/**
	 *
	 * @return int
	 */
	public function getIndex(){
		return $this->getIdTicketClient();
	}


	/**
	 * @return int
	 */
	public function getIdTicketClient(){
		return $this->idTicketClient;
	}

	/**
	 * @param int $idTicketClient
	 * @return TicketClient
	 */
	public function setIdTicketClient($idTicketClient){
		$this->idTicketClient = $idTicketClient;
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
	 * @return TicketClient
	 */
	public function setIdBaseTicket($idBaseTicket){
		$this->idBaseTicket = $idBaseTicket;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getIdClientCategory(){
		return $this->idClientCategory;
	}

	/**
	 * @param int $idClientCategory
	 * @return TicketClient
	 */
	public function setIdClientCategory($idClientCategory){
		$this->idClientCategory = $idClientCategory;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFolio(){
		return (string)$this->folio;
	}

	/**
	 * @param string $folio
	 * @return TicketClient
	 */
	public function setFolio($folio){
		$this->folio = $folio;
		return $this;
	}


	/**
	 * @return string
	 */
	public function getAccountNumber(){
		return $this->accountNumber;
	}

	/**
	 * @param string $accountNumber
	 * @return TicketClient
	 */
	public function setAccountNumber($accountNumber){
		$this->accountNumber = $accountNumber;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdOriginBranch(){
		return $this->idOriginBranch;
	}

	/**
	 * @param int $idOriginBranch
	 * @return TicketClient
	 */
	public function setIdOriginBranch($idOriginBranch){
		$this->idOriginBranch = $idOriginBranch;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdReportedBranch(){
		return $this->idReportedBranch;
	}

	/**
	 * @param int $idReportedBranch
	 * @return TicketClient
	 */
	public function setIdReportedBranch($idReportedBranch){
		$this->idReportedBranch = $idReportedBranch;
		return $this;
	}


	/**
	 * @return int
	 */
	public function getIdProduct(){
		return $this->idProduct;
	}
	
	/**
	 * @param int $idProduct
	 * @return TicketClient
	 */
	public function setIdProduct($idProduct){
		$this->idProduct = $idProduct;
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
	 * @return string
	 */
	public function getFolioPrev() {
		return $this->folioPrev;
	}
	
	/**
	 * @param String $folioPrev
	 * @return TicketClient
	 */
	public function setFolioPrev($folioPrev) {
		$this->folioPrev = $folioPrev;
		return $this;
	}
	

	/**
	 * @return double
	 */
	public function getClientNumber() {
		return $this->clientNumber;
	}
	
	/**
	 * @param String $folioPrev
	 * @return TicketClient
	 */
	public function setClientNumber($clientNumber) {
		$this->clientNumber = $clientNumber;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getIdUserLastAssign(){
		return $this->idUserLastAssign;
	}
	
	/**
	 * @param int $idUserLastAssign
	 * @return TicketClient
	 */
	public function setIdUserLastAssign($idUserLastAssign){
		$this->idUserLastAssign = $idUserLastAssign;
		return $this;
	}
	
	/**
	 * @return String
	 */
	public function getStateClient(){
		return $this->stateClient;
	}
	
	/**
	 * @param String $stateClient
	 * @return TicketClient
	 */
	public function setStateClient($stateClient){
		$this->stateClient = $stateClient;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getNameClient() {
		return $this->nameClient;
	}
	
	/**
	 * @param String $nameClient
	 * @return TicketClient
	 */
	
	public function setNameClient($nameClient) {
		$this->nameClient = $nameClient;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getNoCard() {
		return $this->noCard;
	}
	
	/**
	 * @param String $noClard
	 * @return TicketClient
	 */
	
	public function setNoCard($noCard) {
		$this->noCard = $noCard;
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
	public function getExpirationDate() {
		return $this->expirationDate;
	}
	
	/**
	 * @param String $expirationDate
	 * @return TicketClient
	 */
	
	public function setExpirationDate($expirationDate) {
		$this->expirationDate = $expirationDate;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getChanel(){
		return (string)$this->chanel;
	}
	
	/**
	 * @param string $chanel
	 * @return TicketClient
	 */
	public function setChanel($chanel){
		$this->chanel = $chanel;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getFolioCondusef(){
		return (string)$this->folioCondusef;
	}
	
	/**
	 * @param string $folioCondusef
	 * @return TicketClient
	 */
	public function setFolioCondusef($folioCondusef){
		$this->folioCondusef = $folioCondusef;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getIdResolver(){
		return (int)$this->idResolver;
	}
	
	/**
	 * @param string $idResolver
	 * @return TicketClient
	 */
	public function setIdResolver($idResolver){
		$this->idResolver = $idResolver;
		return $this;
	}
	
	/**
	 * @return String
	 */
	public function getAccountType(){
		return $this->accountType;
	}
	
	/**
	 * @param string $accountType
	 * @return TicketClient
	 */
	public function setAccountType($accountType){
		$this->accountType = $accountType;
		return $this;
	}	

	/**
	 * @return String
	 */
	public function getTelefono(){
		return $this->telefono;
	}
	
	/**
	 * @param string $telefono
	 * @return TicketClient
	 */
	public function setTelefono($telefono){
		$this->telefono = $telefono;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getIdEntidad(){
		return (int)$this->idEntidad;
	}
	
	/**
	 * @param string $idEntidad
	 * @return TicketClient
	 */
	public function setIdEntidad($idEntidad){
		$this->idEntidad= $idEntidad;
		return $this;
	}
	
	/**
	 * @return int
	 */
	public function getComplaint(){
		return $this->complaint;
	}
	
	/**
	 * @param int $complaint
	 * @return TicketClient
	 */
	public function setComplaint($complaint){
		$this->complaint = $complaint;
		return $this;
	}
	
	
	/**
	 * Convert to array
	 * @return array
	 */
	public function toArray()
	{
		$array = array(
				'id_ticket_client' => $this->getIdTicketClient(),
				'id_base_ticket' => $this->getIdBaseTicket(),
				'id_client_category' => $this->getIdClientCategory(),
				'folio' => $this->getFolio(),
				'account_number' => $this->getAccountNumber(),
				'id_origin_branch' => $this->getIdOriginBranch(),
				'id_reported_branch' => $this->getIdReportedBranch(),
				'id_product' => $this->getIdProduct(),	
				'email' => $this->getEmail(),
				'folio_prev' => $this->getFolioPrev(),
				'client_number' => $this->getClientNumber(),
				'id_user_last_assign' => $this->getIdUserLastAssign(),
				'state_client' =>$this->getStateClient(),
				'name_client' =>$this->getNameClient(),
				'no_card' => $this->getNoCard(),
				'employee' => $this->getEmployee(),
				'card_type' => $this->getCardType(),
				'expiration_date' => $this->getExpirationDate(),
				'chanel' => $this->getChanel(),
				'folio_condusef' => $this->getFolioCondusef(),
				'id_resolver' => $this->getIdResolver(),
				'account_type' => $this->getAccountType(),
				'telefono' => $this->getTelefono(),
				'id_entidad' => $this->getIdEntidad(),
				'complaint' => $this->getComplaint(),
		);
		return array_merge(parent::toArray(), $array);
	}
	/**
	 * (non-PHPdoc)
	 * @see Application\Model\Bean.BaseTicket::toArrayForList()
	 */
	public function toArrayForList(){
		$array = array(
				'id_ticket_client' => $this->getIdTicketClient(),
				'id_base_ticket' => $this->getIdBaseTicket(),
				'category' => $this->getCategoryName(),
				'folio' => $this->getFolio(),
				'account_number' => $this->getAccountNumber(),
				'id_origin_branch' => $this->getIdOriginBranch(),
				'id_reported_branch' => $this->getIdReportedBranch(),
				'origin_branch' => $this->getBranchName($this->getIdOriginBranch()),
				'reported_branch' => $this->getBranchName($this->getIdReportedBranch()),
				'is_stopped' => $this->getIsStopped(),
				'id_product' => $this->getIdProduct(),
				'email' => $this->getEmail(),
				'folio_prev' => $this->getFolioPrev(),
				'client_number' => $this->getClientNumber(),
				'id_user_last_assign' => $this->getIdUserLastAssign(),
				'state_client' =>$this->getStateClient(),
				'name_client' =>$this->getNameClient(),
				'no_card' => $this->getNoCard(),
				'employee' => $this->getEmployee(),
				'card_type' => $this->getCardType(),
				'expiration_date' => $this->getExpirationDate(),
				'chanel' => $this->getChanel(),
				'folio_condusef' => $this->getFolioCondusef(),
				'id_resolver' => $this->getIdResolver(),
				'account_type' => $this->getAccountType(),
				'telefono' => $this->getTelefono(),
				'id_entidad' => $this->getIdEntidad(),
		);
		return array_merge(parent::toArrayForList(), $array);
	}
	
	/**
	 * @return string 
	 */
	public function getCategoryName(){
		return ClientCategoryQuery::create()->findByPK($this->getIdClientCategory())->getName();
	}
	
	/**
	 * @return string
	 * @param int $id
	 */
	public function getBranchName($id){
		return BranchQuery::create()->findByPK($id)->getName();
	}
	/**
	 * 
	 * @var array
	 */
	public static $R27ClaimStatus = array(
			'Pending' => '401',
			'Closed' => '402',
			);
	
	public static $periods = array(
			'Seleccionar' => '0',
			'Hoy' => '1',
			'Última Semana' => '2',
			'Último mes' => '3',
			'3 meses' => '4',
			'6 meses' => '5',				
	);
	
}