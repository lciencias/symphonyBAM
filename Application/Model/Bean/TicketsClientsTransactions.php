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
 * TicketsClientsTransactions
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class TicketsClientsTransactions extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_tickets_clients_transactions';

    /**
     * Constants Fields
     */
    const ID_TICKET_CLIENT_TRANSACTION = 'id_ticket_client_transaction';
    const ID_TICKET_CLIENT   = 'id_ticket_client';
    const ID_TRANSACTION_BAM = 'id_transaction_bam';
	const TRANSACTION_DATE   = 'transaction_date';
	const AMOUNT   = 'amount';
	const GOOD_FAITH_PAYMENT = 'good_faith_payment';
	const GOOD_FAITH_DATE    = 'good_faith_date';
	const GOOD_FAITH_AMOUNT  = 'good_faith_amount';
	const ID_CONTROVERSY_CHARGEBACK   = 'id_controversy_chargeback';
	const PAYMENT_REQUEST_DATE   = 'payment_request_date';
	const PAYMENT_DELIVERY_DATE   = 'payment_delivery_date';
	const ACCEPTED_PAYMENT   = 'accepted_payment';
	const DELIVERED_PAYMENT   = 'delivered_payment';
	const TYPE = 'type';
	const FILE_PAYMENT = 'file_payment';
	const FILE_DELIVERY = 'file_delivery';
	const GOOD_FAITH_REQUEST = 'good_faith_request';
	const REFERENCE  = 'reference'; 
	const AFILIATION = 'afiliation';
	const COMMERCE   = 'commerce';
	const DESCRIPTION = 'description';
	const IDT24       = 'idT24';
	/**
	 *
	 * {@inheritDoc}
	 *
	 * @see \Application\Model\Bean\Collectable::getIndex()
	 */
	public function getIndex() {
		// TODO: Auto-generated method stub
	}

	
	

    /**
     * @var int
     */
    private $idTicketClientTransaction;


    /**
     * @var int
     */
    private $idTicketClient;


    /**
     * @var int
     */
    private $idTransactionBam;

    /**
     * @var String
     */
    private $transactionDate;
    
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
     * @var int
     */
    private $idControversyChargeback;
    
    /**
     * @var String
     */
    private $paymentRequestDate;
    
    /**
     * @var String
     */
    private $paymentDeliveryDate;
    
    
    /**
     * @var String
     */
    private $acceptedPayment;
    
    /**
     * @var String
     */
    private $deliveryPayment;
    
    /**
     * @var int
     */
    private $type;
    
    /**
     * @var int
     */
    private $filePayment;
    
    /**
     * @var int
     */
    private $fileDelivery;
    
    
    /**
     * @var int
     */
    private $transactionDateAsZendDate;
    
    /**
     * @var double
     */
    private $goodFaithRequest;
    
    /**
     * @var String
     */
    private $reference;
    
    /**
     * @var String
     */
    private $afiliation;

    /**
     * @var String
     */
    private $commerce;
    
    /**
     * @var String
     */
    private $description;
    
    /**
     * @var String
     */
    private $idT24;
    
    
   
    


    /**
     * @return int
     */
    public function getIdTicketClientTransaction(){
        return $this->idTicketClientTransaction;
    }

    /**
     * @param int $idTicketClientTransaction
     * @return TicketsClientsTransactions
     */
    public function setIdTicketClientTransaction($idTicketClientTransaction){
		$this->idTicketClientTransaction = $idTicketClientTransaction;	
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
     * @return TicketsClientsTransactions
     */
    public function setIdTicketClient($idTicketClient){
		$this->idTicketClient = $idTicketClient;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTransactionBam(){
        return $this->idTransactionBam;
    }

    /**
     * @param int $idTransactionBam
     * @return TicketsClientsTransactions
     */
    public function setIdTransactionBam($idTransactionBam){
		$this->idTransactionBam = $idTransactionBam;	
        return $this;
    }

    /**
     * @return String
     */
    public function getTransactiondate(){
    	return $this->transactionDate;
    }
    
    /**
     * @param String $TransactionDate
     * @return TicketsClientsTransactions
     */
    public function setTransactionDate($transactionDate){
    	$this->transactionDate = $transactionDate;
    	return $this;
    }
    
    /**
     * @return \Zend_Date
     */
    public function getTransactiondateAsZendDate(){
        if( null == $this->transactionDateAsZendDate ){
            $this->transactionDateAsZendDate = new \Zend_Date($this->transactionDate, 'yyyy-MM-dd HH:mm:ss');
        }
        return $this->transactionDateAsZendDate;
    }

    /**
     * @return double
     */
    public function getAmount(){
    	return $this->amount;
    }
    
    /**
     * @param double $amount
     * @return TicketsClientsTransactions
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
     * @return TicketsClientsTransactions
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
     * @return TicketsClientsTransactions
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
     * @return TicketsClientsTransactions
     */
    public function setGoodFaithAmount($goodFaithAmount){
    	$this->goodFaithAmount = $goodFaithAmount;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getIdControversyChargeback(){
    	return $this->idControversyChargeback;
    }
    
    /**
     * @param int  $idControversyChargeback
     * @return TicketsClientsTransactions
     */
    public function setIdControversyChargeback($idControversyChargeback){
    	$this->idControversyChargeback = $idControversyChargeback;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getPaymentRequestDate(){
    	return $this->paymentRequestDate;
    }
    
    /**
     * @param String $paymentRequestDate
     * @return TicketsClientsTransactions
     */
    public function setPaymentRequestDate($paymentRequestDate){
    	$this->paymentRequestDate = $paymentRequestDate;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getPaymentDeliveryDate(){
    	return $this->paymentDeliveryDate;
    }
    
    /**
     * @param String $paymentDeliveryDate
     * @return TicketsClientsTransactions
     */
    public function setPaymentDeliveryDate($paymentDeliveryDate){
    	$this->paymentDeliveryDate = $paymentDeliveryDate;
    	return $this;
    }

    /**
     * @return String
     */
    public function getAcceptedPayment(){
    	return $this->acceptedPayment;
    }
    
    /**
     * @param String $acceptedPayment
     * @return TicketsClientsTransactions
     */
    public function setAcceptedPayment($acceptedPayment){
    	$this->acceptedPayment = $acceptedPayment;
    	return $this;
    }

    /**
     * @return String
     */
    public function getDeliveryPayment(){
    	return $this->deliveryPayment;
    }
    
    /**
     * @param String $deliveryPayment
     * @return TicketsClientsTransactions
     */
    public function setDeliveryPayment($deliveryPayment){
    	$this->deliveryPayment = $deliveryPayment;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getType(){
    	return $this->type;
    }
    
    /**
     * @param int  $type
     * @return TicketsClientsTransactions
     */
    public function setType($type){
    	$this->type = $type;
    	return $this;
    }

    /**
     * @return int
     */
    public function getFilePayment(){
    	return $this->filePayment;
    }
    
    /**
     * @param int  $tfilePayment
     * @return TicketsClientsTransactions
     */
    public function setFilePayment($filePayment){
    	$this->filePayment = $filePayment;
    	return $this;
    }

    /**
     * @return int
     */
    public function getFileDelivery(){
    	return $this->fileDelivery;
    }
    
    /**
     * @param int  $fileDelivery
     * @return TicketsClientsTransactions
     */
    public function setFileDelivery($fileDelivery){
    	$this->fileDelivery = $fileDelivery;
    	return $this;
    }
        
    /**
     * 
     * @return Double
     */
    public function getGoodFaithRequest(){
    	return $this->goodFaithRequest;
    }
    
    /**
     * @param double $goodFaithRequest
     * @return TicketsClientsTransactions
     */
    public function setGoodFaithRequest($goodFaithRequest){
    	$this->goodFaithRequest = $goodFaithRequest;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getReference(){
    	return $this->reference;
    }
    
    /**
     * @param String $reference
     * @return TicketsClientsTransactions
     */
    public function setReference($reference){
    	$this->reference = $reference;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getAfiliation(){
    	return $this->afiliation;
    }
    
    /**
     * @param String $afiliation
     * @return TicketsClientsTransactions
     */
    public function setAfiliation($afiliation){
    	$this->afiliation = $afiliation;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getCommerce(){
    	return $this->commerce;
    }
    
    /**
     * @param String $commerce
     * @return TicketsClientsTransactions
     */
    public function setCommerce($commerce){
    	$this->commerce = $commerce;
    	return $this;
    }
       
    /**
     * @return String
     */
    public function getDescription() {
    	return $this->description;
    }
    
    /**
     * @param String $decription
     * @return TicketsClientsTransactions
     */
    public function setDescription($description) {
    	$this->description = $description;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getIdT24() {
    	return $this->idT24;
    }
    
    /**
     * @param String $idT24
     * @return TicketsClientsTransactions
     */    
    public function setIdT24($idT24) {
    	$this->idT24 = $idT24;
    	return $this;
    }
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_ticket_client_transaction' => $this->getIdTicketClientTransaction(),
            'id_ticket_client'   => $this->getIdTicketClient(),
            'id_transaction_bam' => $this->getIdTransactionBam(),
        	'transaction_date'   => $this->getTransactiondate(),
        	'amount' => $this->getAmount(),
        	'good_faith_payment' => $this->getGoodFaithPayment(),
        	'good_faith_date'    => $this->getGoodFaithDate(),
        	'good_faith_amount'  => $this->getGoodFaithAmount(),
        	'id_controversy_chargeback'  => $this->getIdControversyChargeback(),
        	'payment_request_date'  => $this->getPaymentRequestDate(),
        	'payment_delivery_date'  => $this->getPaymentDeliveryDate(),
        	'accepted_payment'  => $this->getAcceptedPayment(),
        	'delivered_payment'  => $this->getDeliveryPayment(),
        	'type' => $this->getType(),
        	'file_payment' => $this->getFilePayment(),
    		'file_delivery' => $this->getFileDelivery(),
        	'good_faith_request'  => $this->getGoodFaithRequest(),
        	'reference'  => $this->getReference(),
        	'afiliation' => $this->getAfiliation(),
        	'commerce'   => $this->getCommerce(),
        	'description' => $this->getDescription(),
        	'idT24'  => $this->getIdT24(),        		
        );
        return $array;
    }
    
    public function typeTransactions(){
    	$array = array('Sin Tipo','ATM','Transferencia SPEI','Transferencia  cuentas internas','Pago interbancario tarjeta de Crédito',
						'Pago de servicios','Depósito de Cheque','Pago de Cheque','Movimientos con tarjeta de debito');
    	return $array;
    }
}