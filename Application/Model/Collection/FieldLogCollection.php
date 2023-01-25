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

namespace Application\Model\Collection;

use Application\Model\Bean\FieldLog;

/**
 *
 * FieldLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\FieldLog current()
 * @method \Application\Model\Bean\FieldLog read()
 * @method \Application\Model\Bean\FieldLog getOne()
 * @method \Application\Model\Bean\FieldLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\FieldLogCollection intersect() intersect(\Application\Model\Collection\FieldLogCollection $collection)
 * @method \Application\Model\Collection\FieldLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\FieldLogCollection merge() merge(\Application\Model\Collection\FieldLogCollection $collection)
 * @method \Application\Model\Collection\FieldLogCollection diff() diff(\Application\Model\Collection\FieldLogCollection $collection)
 * @method \Application\Model\Collection\FieldLogCollection copy()
 */
class FieldLogCollection extends Collection{

    /**
     *
     * @param FieldLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof FieldLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto FieldLog");
        }
    }


}