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

use Application\Model\Bean\Activity;

/**
 *
 * ActivityCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Activity current()
 * @method \Application\Model\Bean\Activity read()
 * @method \Application\Model\Bean\Activity getOne()
 * @method \Application\Model\Bean\Activity getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ActivityCollection intersect() intersect(\Application\Model\Collection\ActivityCollection $collection)
 * @method \Application\Model\Collection\ActivityCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ActivityCollection merge() merge(\Application\Model\Collection\ActivityCollection $collection)
 * @method \Application\Model\Collection\ActivityCollection diff() diff(\Application\Model\Collection\ActivityCollection $collection)
 * @method \Application\Model\Collection\ActivityCollection copy()
 */
class ActivityCollection extends Collection{

    /**
     *
     * @param Activity $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Activity) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Activity");
        }
    }

    /**
     *
     * @return array
     */
    public function getUserIds(){
        return $this->map(function(Activity $activity){
            return array($activity->getIdUser() => $activity->getIdUser());
        });
    }


}