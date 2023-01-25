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

use Application\Model\Bean\ClientCategoryResolution;

/**
 *
 * ClientCategoryResolutionCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategoryResolution current()
 * @method \Application\Model\Bean\ClientCategoryResolution read()
 * @method \Application\Model\Bean\ClientCategoryResolution getOne()
 * @method \Application\Model\Bean\ClientCategoryResolution getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection intersect() intersect(\Application\Model\Collection\ClientCategoryResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection merge() merge(\Application\Model\Collection\ClientCategoryResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection diff() diff(\Application\Model\Collection\ClientCategoryResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection copy()
 */
class ClientCategoryResolutionCollection extends Collection{

    /**
     *
     * @param ClientCategoryResolution $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientCategoryResolution) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientCategoryResolution");
        }
    }


}