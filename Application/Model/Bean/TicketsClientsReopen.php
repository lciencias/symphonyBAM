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
 * TicketsClientsReopen
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class TicketsClientsReopen extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_tickets_clients_reopen';

    /**
     * Constants Fields
     */
    const ID = 'id';
    const ID_TICKET_CLIENT   = 'id_ticket_client';
    const ID_TICKET_CLIENT_TRANSACTION = 'id_ticket_client_transaction';
    const AMOUNT   = 'amount';
	const GOOD_FAITH_PAYMENT = 'good_faith_payment';
	const GOOD_FAITH_DATE    = 'good_faith_date';
	const GOOD_FAITH_AMOUNT  = 'good_faith_amount';
	const GOOD_FAITH_REQUEST = 'good_faith_request';
	
    /**
     * @var int
     */
    private $id;


    /**
     * @var int
     */
    private $idTicketClient;

    
    /**
     * @var int
     */
    private $idTicketClientTransaction;
    /**
     * @var double
     */
    private $amount;
    
    /**
     * @var String
     */
    private $goodFaithPayment;

    /**
     * @var String
     */
    private $goodFaithDate;
    
    /**
     * @var double
     */
    private $goodFaithAmount;
    
    /**
     * @var double
     */
    private $goodFaithRequest;
    
    
    /**
     *
     * {@inheritDoc}
     *
     * @see \Application\Model\Bean\Collectable::getIndex()
     */
    public function getIndex() {
    	return $this->id;
    }
    
    
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     * @return TicketsClientsReopen
     */
    public function setId($id){
		$this->id = $id;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTicketClient(){
        return $this->idTicketClient;
    }

    /**
     * @param int $idTicketClient
     * @return TicketsClientsReopen
     */
    public function setIdTicketClient($idTicketClient){
		$this->idTicketClient = $idTicketClient;	
        return $this;
    }

    /**
     * @return int
     */
    public function getIdTicketClientTransaction(){
    	return $this->idTicketClientTransaction;
    }
    
    /**
     * @param int $idTicketClientTransaction
     * @return TicketsClientsReopen
     */
    public function setIdTicketClientTransaction($idTicketClientTransaction){
    	$this->idTicketClientTransaction = $idTicketClientTransaction;
    	return $this;
    }
    
    /**
     * @return double
     */
    public function getAmount(){
    	return $this->amount;
    }
    
    /**
     * @param double $amount
     * @return TicketsClientsReopen
     */
    public function setAmount($amount){
    	$this->amount = $amount;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getGoodFaithPayment(){
    	return $this->goodFaithPayment;
    }
    
    /**
     * @param double $goodFaithPayment
     * @return TicketsClientsReopen
     */
    public function setGoodFaithPayment($goodFaithPayment){
    	$this->goodFaithPayment = $goodFaithPayment;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getGoodFaithDate(){
    	return $this->goodFaithDate;
    }
    
    /**
     * @param double $goodFaithDate
     * @return TicketsClientsReopen
     */
    public function setGoodFaithDate($goodFaithDate){
    	$this->goodFaithDate = $goodFaithDate;
    	return $this;
    }
    
    /**
     * @return Double
     */
    public function getGoodFaithAmount(){
    	return $this->goodFaithAmount;
    }
    
    /**
     * @param double $goodFaithAmount
     * @return TicketsClientsReopen
     */
    public function setGoodFaithAmount($goodFaithAmount){
    	$this->goodFaithAmount = $goodFaithAmount;
    	return $this;
    }

    /**
     * @return Double
     */
    public function getGoodFaithRequest(){
    	return $this->goodFaithRequest;
    }
    
    /**
     * @param double $goodFaithRequest
     * @return TicketsClientsReopen
     */
    public function setGoodFaithRequest($goodFaithRequest){
    	$this->goodFaithRequest = $goodFaithRequest;
    	return $this;
    }
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id' => $this->getId(),
            'id_ticket_client'   => $this->getIdTicketClient(),
        	'id_ticket_client_transaction' => $this->getIdTicketClientTransaction(),
        	'amount' => $this->getAmount(),
        	'good_faith_payment' => $this->getGoodFaithPayment(),
        	'good_faith_date'    => $this->getGoodFaithDate(),
        	'good_faith_amount'  => $this->getGoodFaithAmount(),
        	'good_faith_request' => $this->getGoodFaithRequest(),
        	
        );
        return $array;
    }
    
}