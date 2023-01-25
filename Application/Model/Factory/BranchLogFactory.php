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

use Application\Model\Bean\BranchLog;

/**
 *
 * BranchLogFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class BranchLogFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\BranchLog
     */
    public static function createFromArray($fields)
    {
        $branchLog = new BranchLog();
        self::populate($branchLog, $fields);

        return $branchLog;
    }

    /**
     *
     * @static
     * @param BranchLog branchLog
     * @param array $fields
     */
    public static function populate($branchLog, $fields)
    {
        if( !($branchLog instanceof BranchLog) ){
            static::throwException("El objecto no es un BranchLog");
        }

        if( isset($fields['id_branch_log']) ){
            $branchLog->setIdBranchLog($fields['id_branch_log']);
        }

        if( isset($fields['id_user']) ){
            $branchLog->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_branch']) ){
            $branchLog->setIdBranch($fields['id_branch']);
        }

        if( isset($fields['date_log']) ){
            $branchLog->setDateLog($fields['date_log']);
        }

        if( isset($fields['event_type']) ){
            $branchLog->setEventType($fields['event_type']);
        }

        if( isset($fields['notes']) ){
            $branchLog->setNotes($fields['notes']);
        }
    }

    /**
     * @throws BranchLogException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\BranchLogException($message);
    }

}