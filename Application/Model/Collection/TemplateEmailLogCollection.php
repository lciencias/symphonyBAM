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

use Application\Model\Bean\TemplateEmailLog;

/**
 *
 * TemplateEmailLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\TemplateEmailLog current()
 * @method \Application\Model\Bean\TemplateEmailLog read()
 * @method \Application\Model\Bean\TemplateEmailLog getOne()
 * @method \Application\Model\Bean\TemplateEmailLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\TemplateEmailLogCollection intersect() intersect(\Application\Model\Collection\TemplateEmailLogCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TemplateEmailLogCollection merge() merge(\Application\Model\Collection\TemplateEmailLogCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailLogCollection diff() diff(\Application\Model\Collection\TemplateEmailLogCollection $collection)
 * @method \Application\Model\Collection\TemplateEmailLogCollection copy()
 */
class TemplateEmailLogCollection extends Collection{

    /**
     *
     * @param TemplateEmailLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof TemplateEmailLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto TemplateEmailLog");
        }
    }


}