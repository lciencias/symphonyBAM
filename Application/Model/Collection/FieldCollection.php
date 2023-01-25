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

use Application\Model\Bean\Field;

/**
 *
 * FieldCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Field current()
 * @method \Application\Model\Bean\Field read()
 * @method \Application\Model\Bean\Field getOne()
 * @method \Application\Model\Bean\Field getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\FieldCollection intersect() intersect(\Application\Model\Collection\FieldCollection $collection)
 * @method \Application\Model\Collection\FieldCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\FieldCollection merge() merge(\Application\Model\Collection\FieldCollection $collection)
 * @method \Application\Model\Collection\FieldCollection diff() diff(\Application\Model\Collection\FieldCollection $collection)
 * @method \Application\Model\Collection\FieldCollection copy()
 */
class FieldCollection extends Collection{

    /**
     *
     * @param Field $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Field) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Field");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
        $array += $this->map(function(Field $field){
            return array( $field->getIdField() => $field->getName());
        });
        return $array;
    }

}