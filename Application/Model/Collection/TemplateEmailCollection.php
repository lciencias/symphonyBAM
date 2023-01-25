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

use Application\Model\Bean\TemplateEmail;

/**
 *
 * TemplateEmailCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TemplateEmail current()
 * @method \Application\Model\Bean\TemplateEmail read()
 * @method \Application\Model\Bean\TemplateEmail getOne()
 * @method \Application\Model\Bean\TemplateEmail getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TemplateEmailCollection intersect() intersect(\Application\Model\Collection\TemplateEmailCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TemplateEmailCollection merge() merge(\Application\Model\Collection\TemplateEmailCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailCollection diff() diff(\Application\Model\Collection\TemplateEmailCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailCollection copy()
 */
class TemplateEmailCollection extends Collection{

    /**
     *
     * @param TemplateEmail $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TemplateEmail) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TemplateEmail");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(TemplateEmail $templateEmail){
            return array( $templateEmail->getIdTemplateEmail() => $templateEmail->getName() );
        });
    }

}