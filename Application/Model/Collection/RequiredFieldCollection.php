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

use Application\Model\Bean\RequiredField;

/**
 *
 * RequiredFieldCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\RequiredField current()
 * @method \Application\Model\Bean\RequiredField read()
 * @method \Application\Model\Bean\RequiredField getOne()
 * @method \Application\Model\Bean\RequiredField getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\RequiredFieldCollection intersect() intersect(\Application\Model\Collection\RequiredFieldCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\RequiredFieldCollection merge() merge(\Application\Model\Collection\RequiredFieldCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldCollection diff() diff(\Application\Model\Collection\RequiredFieldCollection $collection)
 * @method \Application\Model\Collection\RequiredFieldCollection copy()
 */
class RequiredFieldCollection extends Collection{

    /**
     *
     * @param RequiredField $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof RequiredField) ){
            throw new \InvalidArgumentException("Debe de ser un objecto RequiredField");
        }
    }


}