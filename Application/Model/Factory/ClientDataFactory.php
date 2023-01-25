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

use Application\Model\Bean\ClientData;

/**
 *
 * ClientDataFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class ClientDataFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\ClientData
     */
    public static function createFromArray($fields)
    {
        $clientData = new ClientData();
        self::populate($clientData, $fields);

        return $clientData;
    }

    /**
     *
     * @static
     * @param ClientData clientData
     * @param array $fields
     */
    public static function populate($clientData, $fields)
    {
        if( !($clientData instanceof ClientData) ){
            static::throwException("El objecto no es un ClientData");
        }

        if( isset($fields['client_number']) ){
            $clientData->setClientNumber($fields['client_number']);
        }

        if( isset($fields['name']) ){
            $clientData->setName($fields['name']);
        }

        if( isset($fields['rfc']) ){
            $clientData->setRfc($fields['rfc']);
        }

        if( isset($fields['birthday']) ){
        	 
            $clientData->setBirthday($fields['birthday']);
        }

        if( isset($fields['home_phone']) ){
            $clientData->setHomePhone($fields['home_phone']);
        }

        if( isset($fields['office_phone']) ){
            $clientData->setOfficePhone($fields['office_phone']);
        }

        if( isset($fields['mobile_phone']) ){
            $clientData->setMobilePhone($fields['mobile_phone']);
        }

        if( isset($fields['street']) ){
            $clientData->setStreet($fields['street']);
        }

        if( isset($fields['external_number']) ){
            $clientData->setExternalNumber($fields['external_number']);
        }

        if( isset($fields['internal_number']) ){
            $clientData->setInternalNumber($fields['internal_number']);
        }

        if( isset($fields['state']) ){
            $clientData->setState($fields['state']);
        }

        if( isset($fields['town']) ){
            $clientData->setTown($fields['town']);
        }

        if( isset($fields['colony']) ){
            $clientData->setColony($fields['colony']);
        }

        if( isset($fields['zip_code']) ){
            $clientData->setZipCode($fields['zip_code']);
        }
    }
	public static function populateFromStdClass(ClientData $clientData, \stdClass $stdClass){
		
		if (isset($stdClass->NumCte))
			$clientData->setClientNumber($stdClass->NumCte);
		
		if (isset($stdClass->Nombre))
			$clientData->setName($stdClass->Nombre);
		
		if (isset($stdClass->RFC))
			$clientData->setRfc($stdClass->RFC);
		
		if (isset($stdClass->FechaNac)){
			$date = new \Zend_Date($stdClass->FechaNac,'dd/MM/yyyy');
			$birthday = substr($stdClass->FechaNac, 0,4) . '-' . substr($stdClass->FechaNac, 4,2) . '-' . substr($stdClass->FechaNac, 6,2);
			$clientData->setBirthday($date->get('dd/MMM/yyyy'));
		}
		
		if (isset($stdClass->TelCasa))
			$clientData->setHomePhone($stdClass->TelCasa);
		
		if (isset($stdClass->TelOficina))
			$clientData->setOfficePhone($stdClass->TelOficina);
		
		if (isset($stdClass->TelCelular))
			$clientData->setMobilePhone($stdClass->TelCelular);
		
		if (isset($stdClass->Calle))
			$clientData->setStreet($stdClass->Calle);
		
		if (isset($stdClass->NumExt))
			$clientData->setExternalNumber($stdClass->NumExt);
		
		if (isset($stdClass->NumInt))
			$clientData->setInternalNumber($stdClass->NumInt);
		
		if (isset($stdClass->Estado))
			$clientData->setState($stdClass->Estado);
		
		if (isset($stdClass->MunDel))
			$clientData->setTown($stdClass->MunDel);
		
		if (isset($stdClass->Colonia))
			$clientData->setColony($stdClass->Colonia);
		
		if (isset($stdClass->CP))
			$clientData->setZipCode($stdClass->CP);
	}
    /**
     * @throws ClientDataException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\ClientDataException($message);
    }

}