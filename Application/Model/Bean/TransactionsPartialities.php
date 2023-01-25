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
 * TransactionsPartialities
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class TransactionsPartialities extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_tickets_clients_transactions_partialities';

    /**
     * Constants Fields
     */
    const ID_TICKET_CLIENT_TRANSACTION_PARTIALITY = 'id_ticket_client_transaction_partiality';
    const ID_TICKET_CLIENT_TRANSACTION = 'id_ticket_client_transaction';
    const VOUCHER = 'voucher';
    const AMOUNT = 'amount';
    const DEPOSIT_DATE = 'deposit_date';
    const TYPE = 'type';

    /**
     * @var int
     */
    private $idTicketClientTransactionPartiality;


    /**
     * @var int
     */
    private $idTicketClientTransaction;


    /**
     * @var int
     */
    private $voucher;


    /**
     * @var float
     */
    private $amount;


    /**
     * @var string
     */
    private $depositDate;

    /**
     * @var \Zend_Date
     */
    private $depositDateAsZendDate;


    /**
     * @var string
     */
    private $type;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicketClientTransactionPartiality();
    }


    /**
     * @return int
     */
    public function getIdTicketClientTransactionPartiality(){
        return $this->idTicketClientTransactionPartiality;
    }

    /**
     * @param int $idTicketClientTransactionPartiality
     * @return TransactionsPartialities
     */
    public function setIdTicketClientTransactionPartiality($idTicketClientTransactionPartiality){
		$this->idTicketClientTransactionPartiality = $idTicketClientTransactionPartiality;	
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
     * @return TransactionsPartialities
     */
    public function setIdTicketClientTransaction($idTicketClientTransaction){
		$this->idTicketClientTransaction = $idTicketClientTransaction;	
        return $this;
    }


    /**
     * @return int
     */
    public function getVoucher(){
        return $this->voucher;
    }

    /**
     * @param int $voucher
     * @return TransactionsPartialities
     */
    public function setVoucher($voucher){
		$this->voucher = $voucher;	
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
     * @return TransactionsPartialities
     */
    public function setAmount($amount){
		$var = str_replace('$','',$amount);
	$var = str_replace(',','',$var);
	$this->amount = $var;
		
        return $this;
    }


    /**
     * @return string
     */
    public function getDepositDate(){
        return $this->depositDate;
    }

    /**
     * @param string $depositDate
     * @return TransactionsPartialities
     */
    public function setDepositDate($depositDate){
		$this->depositDate = $depositDate;	
        return $this;
    }

    /**
     * @return \Zend_Date
     */
    public function getDepositDateAsZendDate(){
        if( null == $this->depositDateAsZendDate ){
        	if(!is_null($this->getDepositDate()))
	            $this->depositDateAsZendDate = new PCSDate($this->getDepositDate());
        }
        return $this->depositDateAsZendDate;
    }


    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param string $type
     * @return TransactionsPartialities
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
            'id_ticket_client_transaction_partiality' => $this->getIdTicketClientTransactionPartiality(),
            'id_ticket_client_transaction' => $this->getIdTicketClientTransaction(),
            'voucher' => $this->getVoucher(),
            'amount' => $this->getAmount(),
            'deposit_date' => $this->getDepositDate(),
            'type' => $this->getType(),
        );
        return $array;
    }

}
