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
 * Transactions
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class Transactions extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'transactions';

    /**
     * Constants Fields
     */
    const ID_TRANSACTION = 'id_transaction';
    const TRANSACTION_DATE = 'transaction_date';
    const POST_DATE = 'post_date';
    const DESCRIPTIONS = 'descriptions';
    const REFERENCE_NUMBER = 'reference_number';
    const AMOUNT = 'amount';
    const ID_TYPE_TRANSACTION = 'id_type_transaction';
    const GIRO = 'giro';
    const COMERCE = 'comerce';
    const PEM = 'pem';
    const REFERENCE = 'reference';
    const TIME_TX = 'time_tx';
    const ANSWER = 'answer';
    const ID_REASON = 'id_reason';
    const AUTHORIZATION_NUMBER = 'authorization_number';
    const AFILITION = 'afilition';
    const SEQUENCE = 'sequence';
    const RESPONSE = 'response';

    /**
     * @var int
     */
    private $idTransaction;


    /**
     * @var string
     */
    private $transactionDate;

    /**
     * @var \Zend_Date
     */
    private $transactionDateAsZendDate;


    /**
     * @var string
     */
    private $postDate;

    /**
     * @var \Zend_Date
     */
    private $postDateAsZendDate;


    /**
     * @var string
     */
    private $descriptions;


    /**
     * @var string
     */
    private $referenceNumber;


    /**
     * @var float
     */
    private $amount;


    /**
     * @var int
     */
    private $idTypeTransaction;


    /**
     * @var string
     */
    private $giro;


    /**
     * @var string
     */
    private $comerce;


    /**
     * @var string
     */
    private $pem;


    /**
     * @var string
     */
    private $reference;


    /**
     * @var string
     */
    private $timeTx;


    /**
     * @var string
     */
    private $answer;


    /**
     * @var int
     */
    private $idReason;


    /**
     * @var int
     */
    private $authorizationNumber;


    /**
     * @var string
     */
    private $afilition;


    /**
     * @var int
     */
    private $sequence;


    /**
     * @var string
     */
    private $response;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTransaction();
    }


    /**
     * @return int
     */
    public function getIdTransaction(){
        return $this->idTransaction;
    }

    /**
     * @param int $idTransaction
     * @return Transactions
     */
    public function setIdTransaction($idTransaction){
		$this->idTransaction = $idTransaction;	
        return $this;
    }


    /**
     * @return string
     */
    public function getTransactionDate(){
        return $this->transactionDate;
    }

    /**
     * @param string $transactionDate
     * @return Transactions
     */
    public function setTransactionDate($transactionDate){
		$this->transactionDate = $transactionDate;	
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getTransactionDateAsZendDate(){
        if( null == $this->transactionDateAsZendDate ){
        	if(!is_null($this->getTransactionDate()))
	            $this->transactionDateAsZendDate = new PCSDate($this->getTransactionDate());
        }
        return $this->transactionDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getPostDate(){
        return $this->postDate;
    }

    /**
     * @param string $postDate
     * @return Transactions
     */
    public function setPostDate($postDate){
		$this->postDate = $postDate;	
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getPostDateAsZendDate(){
        if( null == $this->postDateAsZendDate ){
        	if(!is_null($this->getPostDate()))
	            $this->postDateAsZendDate = new PCSDate($this->getPostDate());
        }
        return $this->postDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getDescriptions(){
        return $this->descriptions;
    }

    /**
     * @param string $descriptions
     * @return Transactions
     */
    public function setDescriptions($descriptions){
		$this->descriptions = $descriptions;	
        return $this;
    }


    /**
     * @return string
     */
    public function getReferenceNumber(){
        return $this->referenceNumber;
    }

    /**
     * @param string $referenceNumber
     * @return Transactions
     */
    public function setReferenceNumber($referenceNumber){
		$this->referenceNumber = $referenceNumber;	
        return $this;
    }


    /**
     * @return float
     */
    public function getAmount(){
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transactions
     */
    public function setAmount($amount){
		$var = str_replace('$','',$amount);
	$var = str_replace(',','',$var);
	$this->amount = $var;
		
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTypeTransaction(){
        return $this->idTypeTransaction;
    }

    /**
     * @param int $idTypeTransaction
     * @return Transactions
     */
    public function setIdTypeTransaction($idTypeTransaction){
		$this->idTypeTransaction = $idTypeTransaction;	
        return $this;
    }


    /**
     * @return string
     */
    public function getGiro(){
        return $this->giro;
    }

    /**
     * @param string $giro
     * @return Transactions
     */
    public function setGiro($giro){
		$this->giro = $giro;	
        return $this;
    }


    /**
     * @return string
     */
    public function getComerce(){
        return $this->comerce;
    }

    /**
     * @param string $comerce
     * @return Transactions
     */
    public function setComerce($comerce){
		$this->comerce = $comerce;	
        return $this;
    }


    /**
     * @return string
     */
    public function getPem(){
        return $this->pem;
    }

    /**
     * @param string $pem
     * @return Transactions
     */
    public function setPem($pem){
		$this->pem = $pem;	
        return $this;
    }


    /**
     * @return string
     */
    public function getReference(){
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return Transactions
     */
    public function setReference($reference){
		$this->reference = $reference;	
        return $this;
    }


    /**
     * @return string
     */
    public function getTimeTx(){
        return $this->timeTx;
    }

    /**
     * @param string $timeTx
     * @return Transactions
     */
    public function setTimeTx($timeTx){
		$this->timeTx = $timeTx;	
        return $this;
    }


    /**
     * @return string
     */
    public function getAnswer(){
        return $this->answer;
    }

    /**
     * @param string $answer
     * @return Transactions
     */
    public function setAnswer($answer){
		$this->answer = $answer;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdReason(){
        return $this->idReason;
    }

    /**
     * @param int $idReason
     * @return Transactions
     */
    public function setIdReason($idReason){
		$this->idReason = $idReason;	
        return $this;
    }


    /**
     * @return int
     */
    public function getAuthorizationNumber(){
        return $this->authorizationNumber;
    }

    /**
     * @param int $authorizationNumber
     * @return Transactions
     */
    public function setAuthorizationNumber($authorizationNumber){
		$this->authorizationNumber = $authorizationNumber;	
        return $this;
    }


    /**
     * @return string
     */
    public function getAfilition(){
        return $this->afilition;
    }

    /**
     * @param string $afilition
     * @return Transactions
     */
    public function setAfilition($afilition){
		$this->afilition = $afilition;	
        return $this;
    }


    /**
     * @return int
     */
    public function getSequence(){
        return $this->sequence;
    }

    /**
     * @param int $sequence
     * @return Transactions
     */
    public function setSequence($sequence){
		$this->sequence = $sequence;	
        return $this;
    }


    /**
     * @return string
     */
    public function getResponse(){
        return $this->response;
    }

    /**
     * @param string $response
     * @return Transactions
     */
    public function setResponse($response){
		$this->response = $response;	
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_transaction' => $this->getIdTransaction(),
            'transaction_date' => $this->getTransactionDate(),
            'post_date' => $this->getPostDate(),
            'descriptions' => $this->getDescriptions(),
            'reference_number' => $this->getReferenceNumber(),
            'amount' => $this->getAmount(),
            'id_type_transaction' => $this->getIdTypeTransaction(),
            'giro' => $this->getGiro(),
            'comerce' => $this->getComerce(),
            'pem' => $this->getPem(),
            'reference' => $this->getReference(),
            'time_tx' => $this->getTimeTx(),
            'answer' => $this->getAnswer(),
            'id_reason' => $this->getIdReason(),
            'authorization_number' => $this->getAuthorizationNumber(),
            'afilition' => $this->getAfilition(),
            'sequence' => $this->getSequence(),
            'response' => $this->getResponse(),
        );
        return $array;
    }

}
