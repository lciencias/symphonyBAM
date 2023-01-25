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

use Application\Model\Bean\RequiredFieldLog;

/**
 *
 * RequiredFieldLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\RequiredFieldLog current()
 * @method \Application\Model\Bean\RequiredFieldLog read()
 * @method \Application\Model\Bean\RequiredFieldLog getOne()
 * @method \Application\Model\Bean\RequiredFieldLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\RequiredFieldLogCollection intersect() intersect(\Application\Model\Collection\RequiredFieldLogCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\RequiredFieldLogCollection merge() merge(\Application\Model\Collection\RequiredFieldLogCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldLogCollection diff() diff(\Application\Model\Collection\RequiredFieldLogCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldLogCollection copy()
 */
class RequiredFieldLogCollection extends Collection{

    /**
     *
     * @param RequiredFieldLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof RequiredFieldLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto RequiredFieldLog");
        }
    }


}