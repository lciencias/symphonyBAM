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

use Application\Model\Bean\ControversyReasons;

/**
 *
 * ControversyReasonsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyReasons current()
 * @method \Application\Model\Bean\ControversyReasons read()
 * @method \Application\Model\Bean\ControversyReasons getOne()
 * @method \Application\Model\Bean\ControversyReasons getOneOrElse() getOneOrElse(Application\Model\Bean\ControversyReasons $controversyReasons)
 * @method \Application\Model\Bean\ControversyReasons getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\ControversyReasons getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\ControversyReasons $controversyReasons)
 * @method \Application\Model\Collection\ControversyReasonsCollection intersect() intersect(\Application\Model\Collection\ControversyReasonsCollection $collection)
 * @method \Application\Model\Collection\ControversyReasonsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ControversyReasonsCollection merge() merge(\Application\Model\Collection\ControversyReasonsCollection $collection)
 * @method \Application\Model\Collection\ControversyReasonsCollection diff() diff(\Application\Model\Collection\ControversyReasonsCollection $collection)
 * @method \Application\Model\Collection\ControversyReasonsCollection copy()
 */
class ControversyReasonsCollection extends Collection{

    /**
     *
     * @param ControversyReasons $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ControversyReasons) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ControversyReasons");
        }
    }

    
    /**
     * @return array
     */
    public function toCombo($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(ControversyReasons $controversyReasons){
    			        return array( $controversyReasons->getIdControversyReason() => $controversyReasons->getName() );
    		});
    			return $array;
    }
    

    /**
     *
     * @return \Application\Model\Collection\ControversyReasonsCollection
     */
    public function actives(){
        return $this->filter(function(ControversyReasons $controversyReasons){
            return $controversyReasons->isActive();
        });
    }
    
    /**
     *
     * @return \Application\Model\Collection\ControversyReasonsCollection
     */
    public function inactives(){
        return $this->filter(function(ControversyReasons $controversyReasons){
            return $controversyReasons->isInactive();
        });
    }



}