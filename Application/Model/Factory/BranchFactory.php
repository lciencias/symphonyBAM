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

use Application\Model\Bean\Branch;

/**
 *
 * BranchFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class BranchFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Branch
     */
    public static function createFromArray($fields)
    {
        $branch = new Branch();
        self::populate($branch, $fields);

        return $branch;
    }

    /**
     *
     * @static
     * @param Branch branch
     * @param array $fields
     */
    public static function populate($branch, $fields)
    {
        if( !($branch instanceof Branch) ){
            static::throwException("El objecto no es un Branch");
        }

        if( isset($fields['id_branch']) ){
            $branch->setIdBranch($fields['id_branch']);
        }

        if( isset($fields['id_country_state']) ){
            $branch->setIdCountryState($fields['id_country_state']);
        }

        if( isset($fields['name']) ){
            $branch->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $branch->setStatus($fields['status']);
        }
        
        if( isset($fields['id_bam']) ){
            $branch->setIdBam($fields['id_bam']);
        }
        
        if( isset($fields['address']) ){
            $branch->setAddress($fields['address']);
        }
        
        if( isset($fields['scheduled']) ){
            $branch->setScheduled($fields['scheduled']);
        }
    }

    /**
     * @throws BranchException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\BranchException($message);
    }

}