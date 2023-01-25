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

use Application\Model\Bean\ClientCategoryLog;

/**
 *
 * ClientCategoryLogCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategoryLog current()
 * @method \Application\Model\Bean\ClientCategoryLog read()
 * @method \Application\Model\Bean\ClientCategoryLog getOne()
 * @method \Application\Model\Bean\ClientCategoryLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientCategoryLogCollection intersect() intersect(\Application\Model\Collection\ClientCategoryLogCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientCategoryLogCollection merge() merge(\Application\Model\Collection\ClientCategoryLogCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryLogCollection diff() diff(\Application\Model\Collection\ClientCategoryLogCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryLogCollection copy()
 */
class ClientCategoryLogCollection extends Collection{

    /**
     *
     * @param ClientCategoryLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientCategoryLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientCategoryLog");
        }
    }


}