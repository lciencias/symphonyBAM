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
 * ClientAccount
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class ClientAccount extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_client_accounts';

    /**
     * Constants Fields
     */
    const ACCOUNT = 'account';
    const TYPE = 'type';
    const CARD_NUMBER = 'card_number';

    /**
     * @var string
     */
    private $account;


    /**
     * @var string
     */
    private $type;


    /**
     * @var string
     */
    private $cardNumber;


	public function getIndex(){
		return $this->getAccount();
	}
    /**
     * @return string
     */
    public function getAccount(){
        return $this->account;
    }

    /**
     * @param string $account
     * @return ClientAccount
     */
    public function setAccount($account){
        $this->account = $account;
        return $this;
    }


    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param string $type
     * @return ClientAccount
     */
    public function setType($type){
        $this->type = $type;
        return $this;
    }


    /**
     * @return string
     */
    public function getCardNumber(){
        return $this->cardNumber;
    }

    /**
     * @param string $cardNumber
     * @return ClientAccount
     */
    public function setCardNumber($cardNumber){
        $this->cardNumber = $cardNumber;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'account' => $this->getAccount(),
            'type' => $this->getType(),
            'card_number' => $this->getCardNumber(),
        );
        return $array;
    }

}