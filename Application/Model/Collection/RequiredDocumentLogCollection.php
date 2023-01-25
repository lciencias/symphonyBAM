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

use Application\Model\Bean\RequiredDocumentLog;

/**
 *
 * RequiredDocumentLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\RequiredDocumentLog current()
 * @method \Application\Model\Bean\RequiredDocumentLog read()
 * @method \Application\Model\Bean\RequiredDocumentLog getOne()
 * @method \Application\Model\Bean\RequiredDocumentLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection intersect() intersect(\Application\Model\Collection\RequiredDocumentLogCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection merge() merge(\Application\Model\Collection\RequiredDocumentLogCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection diff() diff(\Application\Model\Collection\RequiredDocumentLogCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentLogCollection copy()
 */
class RequiredDocumentLogCollection extends Collection{

    /**
     *
     * @param RequiredDocumentLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof RequiredDocumentLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto RequiredDocumentLog");
        }
    }


}