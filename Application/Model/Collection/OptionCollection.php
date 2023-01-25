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

use Application\Model\Bean\Option;

/**
 *
 * OptionCollection
 *
 * @author guadalupe, chente
 * @method \Application\Base\Option current()
 * @method \Application\Base\Option read()
 * @method \Application\Base\Option getOne()
 * @method \Application\Base\Option getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\OptionCollection intersect() intersect(\Application\Model\Collection\OptionCollection $collection)
 * @method \Application\Model\Collection\OptionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\OptionCollection merge() merge(\Application\Model\Collection\OptionCollection $collection)
 * @method \Application\Model\Collection\OptionCollection diff() diff(\Application\Model\Collection\OptionCollection $collection)
 * @method \Application\Model\Collection\OptionCollection copy()
 */
class OptionCollection extends Collection{

    /**
     *
     * @param Option $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Option) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Option");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Option $option){
            return array( $option->getIdOption() => $option->getName() );
        });
    }

}