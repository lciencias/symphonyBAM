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

namespace Application\Model\Factory;

use Application\Model\Bean\ClientAccount;

/**
 *
 * ClientAccountFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientAccountFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientAccount
     */
    public static function createFromArray($fields)
    {
        $clientAccount = new ClientAccount();
        self::populate($clientAccount, $fields);

        return $clientAccount;
    }

    /**
     *
     * @static
     * @param ClientAccount clientAccount
     * @param array $fields
     */
    public static function populate($clientAccount, $fields)
    {
        if( !($clientAccount instanceof ClientAccount) ){
            static::throwException("El objecto no es un ClientAccount");
        }

        if( isset($fields['account']) ){
            $clientAccount->setAccount($fields['account']);
        }

        if( isset($fields['type']) ){
            $clientAccount->setType($fields['type']);
        }

        if( isset($fields['card_number']) ){
            $clientAccount->setCardNumber($fields['card_number']);
        }
    }
    /**
     * 
     * @param ClientAccount $clientAccount
     * @param \stdClass $stdClass
     */
	public static function populateFromStdClass(ClientAccount $clientAccount,\stdClass $stdClass){

		if(isset($stdClass->NumCta))
			$clientAccount->setAccount($stdClass->NumCta);
		
		if (isset($stdClass->TipoProd))
			$clientAccount->setType($stdClass->TipoProd);
		
		if (isset($stdClass->NumTarjeta))
			$clientAccount->setCardNumber($stdClass->NumTarjeta);
		
	}
    /**
     * @throws ClientAccountException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientAccountException($message);
    }

}