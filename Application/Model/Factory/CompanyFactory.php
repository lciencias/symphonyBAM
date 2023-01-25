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

namespace Application\Model\Factory;

use Application\Model\Bean\Company;

/**
 *
 * CompanyFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CompanyFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Company
     */
    public static function createFromArray($fields)
    {
        $company = new Company();
        self::populate($company, $fields);

        return $company;
    }

    /**
     *
     * @static
     * @param Company company
     * @param array $fields
     */
    public static function populate($company, $fields)
    {
        if( !($company instanceof Company) ){
            static::throwException("El objecto no es un Company");
        }

        if( isset($fields['id_company']) ){
            $company->setIdCompany($fields['id_company']);
        }

        if( isset($fields['name']) ){
            $company->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $company->setStatus($fields['status']);
        }
    }

    /**
     * @throws CompanyException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CompanyException($message);
    }

}