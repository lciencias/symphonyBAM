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

use Application\Model\Bean\ClientResolutionLog;

/**
 *
 * ClientResolutionLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientResolutionLog current()
 * @method \Application\Model\Bean\ClientResolutionLog read()
 * @method \Application\Model\Bean\ClientResolutionLog getOne()
 * @method \Application\Model\Bean\ClientResolutionLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientResolutionLogCollection intersect() intersect(\Application\Model\Collection\ClientResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientResolutionLogCollection merge() merge(\Application\Model\Collection\ClientResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionLogCollection diff() diff(\Application\Model\Collection\ClientResolutionLogCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionLogCollection copy()
 */
class ClientResolutionLogCollection extends Collection{

    /**
     *
     * @param ClientResolutionLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientResolutionLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientResolutionLog");
        }
    }


}