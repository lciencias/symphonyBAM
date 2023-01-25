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
 * File
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class FileTmp extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_files_tmp';

    /**
     * Constants Fields
     */
    const ID_FILE = 'id_file';
    const URI = 'uri';
    const ORIGINAL_NAME  = 'original_name';
    const ID_TRANSACTION = 'id_transaction';
    const AMOUNT_DEPOSIT = 'amount_deposit';
    const DATE_DEPOSIT   = 'date_deposit';
    const TYPE_DEPOSIT   = 'type_deposit';
    const ID_SESSION     = 'id_session';


    /**
     * @var int
     */
    private $idFile;


    /**
     * @var string
     */
    private $uri;


    /**
     * @var string
     */
    private $originalName;


    /**
     * @var int
     */
    private $idTransaction;

    /**
     * @var int
     */
    private $typeDeposit;
    
    /**
     * @var FLOAT
     */
    private $amountDeposit;

    /**
     * @var string
     */
    private $dateDeposit;
    
    /**
     * @var int
     */
    private $idSession;
    
    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdFile();
    }


    /**
     * @return int
     */
    public function getIdFile(){
        return $this->idFile;
    }

    /**
     * @param int $idFile
     * @return FileTmp
     */
    public function setIdFile($idFile){
        $this->idFile = $idFile;
        return $this;
    }


    /**
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return FileTmp
     */
    public function setUri($uri){
        $this->uri = $uri;
        return $this;
    }


    /**
     * @return string
     */
    public function getOriginalName(){
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return FileTmp
     */
    public function setOriginalName($originalName){
        $this->originalName = $originalName;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTransaction(){
    	return $this->idTransaction;
    }
    
    /**
     * @param int $idTransaction
     * @return FileTmp
     */
    public function setIdTransaction($idTransaction){
    	$this->idTransaction = $idTransaction;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getTypeDeposit(){
    	return $this->typeDeposit;
    }
    
    /**
     * @param int $idTypeDeposit
     * @return FileTmp
     */
    public function setTypeDeposit($TypeDeposit){
    	$this->typeDeposit = $TypeDeposit;
    	return $this;
    }
    
    /**
     * @return int
     */
    public function getAmountDeposit(){
    	return $this->amountDeposit;
    }
    
    /**
     * @param int $amountDeposit
     * @return FileTmp
     */
    public function setAmountDeposit($amountDeposit){
    	$this->amountDeposit = $amountDeposit;
    	return $this;
    }
    
    /**
     * @return String
     */
    public function getDateDeposit(){
    	return $this->dateDeposit;
    }
    
    /**
     * @param int $dateDeposit
     * @return FileTmp
     */
    public function setDateDeposit($dateDeposit){
    	$this->dateDeposit = $dateDeposit;
    	return $this;
    }
    
    /**
     * @return string
     */
    public function getIdSession(){
    	return $this->idSession;
    }
    
    /**
     * @param string $idSession
     * @return FileTmp
     */
    public function setIdSession($idSession){
    	$this->idSession = $idSession;
    	return $this;
    }
    
    
    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_file' => $this->getIdFile(),
            'uri' => $this->getUri(),
            'original_name' => $this->getOriginalName(),
        	'id_transaction' => $this->getIdTransaction(),
        	'amount_deposit' => $this->getAmountDeposit(),        		
        	'date_deposit'   => $this->getDateDeposit(),
        	'type_deposit'   => $this->getTypeDeposit(),
        	'id_session'     => $this->getIdSession(),
        );
        return $array;
    }

}