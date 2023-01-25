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

use Application\Model\Bean\DocumentLog;

/**
 *
 * DocumentLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\DocumentLog current()
 * @method \Application\Model\Bean\DocumentLog read()
 * @method \Application\Model\Bean\DocumentLog getOne()
 * @method \Application\Model\Bean\DocumentLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\DocumentLogCollection intersect() intersect(\Application\Model\Collection\DocumentLogCollection $collection)
 * @method \Application\Model\Collection\DocumentLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\DocumentLogCollection merge() merge(\Application\Model\Collection\DocumentLogCollection $collection)
 * @method \Application\Model\Collection\DocumentLogCollection diff() diff(\Application\Model\Collection\DocumentLogCollection $collection)
 * @method \Application\Model\Collection\DocumentLogCollection copy()
 */
class DocumentLogCollection extends Collection{

    /**
     *
     * @param DocumentLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof DocumentLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto DocumentLog");
        }
    }


}