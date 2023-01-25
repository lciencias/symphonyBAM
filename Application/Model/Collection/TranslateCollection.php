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

use Application\Model\Bean\Translate;

/**
 *
 * TranslateCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Translate current()
 * @method \Application\Model\Bean\Translate read()
 * @method \Application\Model\Bean\Translate getOne()
 * @method \Application\Model\Bean\Translate getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TranslateCollection intersect() intersect(\Application\Model\Collection\TranslateCollection $collection)
 * @method \Application\Model\Collection\TranslateCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TranslateCollection merge() merge(\Application\Model\Collection\TranslateCollection $collection)
 * @method \Application\Model\Collection\TranslateCollection diff() diff(\Application\Model\Collection\TranslateCollection $collection)
 * @method \Application\Model\Collection\TranslateCollection copy()
 */
class TranslateCollection extends Collection{

    /**
     *
     * @param Translate $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Translate) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Translate");
        }
    }


}