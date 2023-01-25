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

use Application\Model\Bean\BranchLog;

/**
 *
 * BranchLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\BranchLog current()
 * @method \Application\Model\Bean\BranchLog read()
 * @method \Application\Model\Bean\BranchLog getOne()
 * @method \Application\Model\Bean\BranchLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\BranchLogCollection intersect() intersect(\Application\Model\Collection\BranchLogCollection $collection)
 * @method \Application\Model\Collection\BranchLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\BranchLogCollection merge() merge(\Application\Model\Collection\BranchLogCollection $collection)
 * @method \Application\Model\Collection\BranchLogCollection diff() diff(\Application\Model\Collection\BranchLogCollection $collection)
 * @method \Application\Model\Collection\BranchLogCollection copy()
 */
class BranchLogCollection extends Collection{

    /**
     *
     * @param BranchLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof BranchLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto BranchLog");
        }
    }


}