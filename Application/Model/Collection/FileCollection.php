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

use Application\Model\Bean\File;

/**
 *
 * FileCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\File current()
 * @method \Application\Model\Bean\File read()
 * @method \Application\Model\Bean\File getOne()
 * @method \Application\Model\Bean\File getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\FileCollection intersect() intersect(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\FileCollection merge() merge(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileCollection diff() diff(\Application\Model\Collection\FileCollection $collection)
 * @method \Application\Model\Collection\FileCollection copy()
 */
class FileCollection extends Collection{

    /**
     *
     * @param File $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof File) ){
            throw new \InvalidArgumentException("Debe de ser un objecto File");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(File $file){
            return array( $file->getIdFile() => $file->getOriginalName() );
        });
    }

}