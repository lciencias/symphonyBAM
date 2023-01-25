<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Collection;

use Application\Model\Bean\MexicoZipCode;

/**
 *
 * MexicoZipCodeCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\MexicoZipCode current()
 * @method \Application\Model\Bean\MexicoZipCode read()
 * @method \Application\Model\Bean\MexicoZipCode getOne()
 * @method \Application\Model\Bean\MexicoZipCode getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\MexicoZipCodeCollection intersect() intersect(\Application\Model\Collection\MexicoZipCodeCollection $collection)
 * @method \Application\Model\Collection\MexicoZipCodeCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\MexicoZipCodeCollection merge() merge(\Application\Model\Collection\MexicoZipCodeCollection $collection)
 * @method \Application\Model\Collection\MexicoZipCodeCollection diff() diff(\Application\Model\Collection\MexicoZipCodeCollection $collection)
 * @method \Application\Model\Collection\MexicoZipCodeCollection copy()
 */
class MexicoZipCodeCollection extends Collection{

    /**
     *
     * @param MexicoZipCode $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof MexicoZipCode) ){
            throw new \InvalidArgumentException("Debe de ser un objecto MexicoZipCode");
        }
    }


}