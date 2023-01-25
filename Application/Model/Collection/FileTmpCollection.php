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

use Application\Model\Bean\FileTmp;

/**
 *
 * FileCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\FileTmp current()
 * @method \Application\Model\Bean\FileTmp read()
 * @method \Application\Model\Bean\FileTmp getOne()
 * @method \Application\Model\Bean\FileTmp getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\FileTmpCollection intersect() intersect(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileTmpCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\FileTmpCollection merge() merge(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileTmpCollection diff() diff(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileTmpCollection copy()
 */
class FileTmpCollection extends Collection{

    /**
     *
     * @param FileTmp $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof FileTmp) ){
            throw new \InvalidArgumentException("Debe de ser un objecto FileTmp");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(FileTmp $fileTmp){
            return array( $fileTmp->getIdFile() => $fileTmp->getOriginalName() );
        });
    }

}