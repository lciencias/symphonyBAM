<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Collection;

use Application\Model\Bean\Reasons;

/**
 *
 * ReasonsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Reasons current()
 * @method \Application\Model\Bean\Reasons read()
 * @method \Application\Model\Bean\Reasons getOne()
 * @method \Application\Model\Bean\Reasons getOneOrElse() getOneOrElse(Application\Model\Bean\Reasons $reasons)
 * @method \Application\Model\Bean\Reasons getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\Reasons getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\Reasons $reasons)
 * @method \Application\Model\Collection\ReasonsCollection intersect() intersect(\Application\Model\Collection\ReasonsCollection $collection)
 * @method \Application\Model\Collection\ReasonsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ReasonsCollection merge() merge(\Application\Model\Collection\ReasonsCollection $collection)
 * @method \Application\Model\Collection\ReasonsCollection diff() diff(\Application\Model\Collection\ReasonsCollection $collection)
 * @method \Application\Model\Collection\ReasonsCollection copy()
 */
class ReasonsCollection extends Collection{

    /**
     *
     * @param Reasons $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Reasons) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Reasons");
        }
    }

    /**
     * @return array
     */
    
    
    public function toCombo($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(Reasons $reasons){
    			return array( $reasons->getIdReason() => $reasons->getName() );
    		});
    		return $array;
    }
    
    /**
    * @return array
    */
    public function toComboConcat($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(Reasons $reasons){
    			return array( $reasons->getIdReason().'-'.(int)$reasons->getFinancialMovement().'-'.(int)$reasons->getPartialities() => $reasons->getName() );
    		});
    		return $array;
    }

}