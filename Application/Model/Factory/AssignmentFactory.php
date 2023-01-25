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

use Application\Model\Bean\Assignment;

/**
 *
 * AssignmentFactory
 *
 * @category Application\Model\Factory
 * @author jose luis
 */
class AssignmentFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Assignment
     */
    public static function createFromArray($fields)
    {
        $assignment = new Assignment();
        self::populate($assignment, $fields);

        return $assignment;
    }

    /**
     *
     * @static
     * @param Assignment assignment
     * @param array $fields
     */
    public static function populate($assignment, $fields)
    {
        if( !($assignment instanceof Assignment) ){
            static::throwException("El objecto no es un Assignment");
        }

        if( isset($fields['id_assignment']) ){
            $assignment->setIdAssignment($fields['id_assignment']);
        }

        if( isset($fields['id_base_ticket']) ){
            $assignment->setIdBaseTicket($fields['id_base_ticket']);
        }

        if( isset($fields['id_user']) ){
            $assignment->setIdUser($fields['id_user']);
        }

        if( isset($fields['id_resolution']) ){
            $assignment->setIdResolution($fields['id_resolution']);
        }

        if( isset($fields['assignment_date']) ){
            $assignment->setAssignmentDate($fields['assignment_date']);
        }

        if( isset($fields['resolution_date']) ){
            $assignment->setResolutionDate($fields['resolution_date']);
        }

        if( isset($fields['note']) ){
            $assignment->setNote($fields['note']);
        }

        if( isset($fields['id_file']) ){
            $assignment->setIdFile($fields['id_file']);
        }
        if( isset($fields['recovery_amount']) ){
        	$assignment->setRecoveryAmount($fields['recovery_amount']);
        }
        if( isset($fields['is_recovered_amount']) ){
        	$assignment->setIsRecoveredAmount($fields['is_recovered_amount']);
        }
        if( isset($fields['id_resolution_file']) ){
        	$assignment->setIdResolutionFile($fields['id_resolution_file']);
        }
        if( isset($fields['status']) ){
        	$assignment->setStatus($fields['status']);
        }
    }

    /**
     * @throws AssignmentException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\AssignmentException($message);
    }

}