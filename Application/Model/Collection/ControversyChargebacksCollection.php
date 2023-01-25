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

use Application\Model\Bean\ControversyChargebacks;

/**
 *
 * ControversyChargebacksCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyChargebacks current()
 * @method \Application\Model\Bean\ControversyChargebacks read()
 * @method \Application\Model\Bean\ControversyChargebacks getOne()
 * @method \Application\Model\Bean\ControversyChargebacks getOneOrElse() getOneOrElse(Application\Model\Bean\ControversyChargebacks $controversyChargebacks)
 * @method \Application\Model\Bean\ControversyChargebacks getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\ControversyChargebacks getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\ControversyChargebacks $controversyChargebacks)
 * @method \Application\Model\Collection\ControversyChargebacksCollection intersect() intersect(\Application\Model\Collection\ControversyChargebacksCollection $collection)
 * @method \Application\Model\Collection\ControversyChargebacksCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ControversyChargebacksCollection merge() merge(\Application\Model\Collection\ControversyChargebacksCollection $collection)
 * @method \Application\Model\Collection\ControversyChargebacksCollection diff() diff(\Application\Model\Collection\ControversyChargebacksCollection $collection)
 * @method \Application\Model\Collection\ControversyChargebacksCollection copy()
 */
class ControversyChargebacksCollection extends Collection{

    /**
     *
     * @param ControversyChargebacks $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ControversyChargebacks) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ControversyChargebacks");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(ControversyChargebacks $controversyChargebacks){
            	return array( $controversyChargebacks->getIdControversyChargeback() => $controversyChargebacks->getName() );
    		});
    		return $array;
    }
    
    /**
     * @return array
     */
    public function toComboType($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(ControversyChargebacks $controversyChargebacks){
    			return array( $controversyChargebacks->getType() => $controversyChargebacks->getName() );
    		});
    			return $array;
    }
    
    
    /**
     *
     * @return \Application\Model\Collection\ControversyChargebacksCollection
     */
    public function actives(){
        return $this->filter(function(ControversyChargebacks $controversyChargebacks){
            return $controversyChargebacks->isActive();
        });
    }
    
    /**
     *
     * @return \Application\Model\Collection\ControversyChargebacksCollection
     */
    public function inactives(){
        return $this->filter(function(ControversyChargebacks $controversyChargebacks){
            return $controversyChargebacks->isInactive();
        });
    }


	/**
	 * Returns an array with ids the ControversyReasons
	 * @return array
	 */
	public function getControversyReasonsIds()
	{
		return $this->map(function(ControversyChargebacks $controversyChargebacks){
			return array( $controversyChargebacks->getIdControversyReasons() => $controversyChargebacks->getIdControversyReasons() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ControversyChargebacksCollection
     */
	public function getByIdControversyReasons($idControversyReasons)
	{
		$controversyChargebacksCollection = new ControversyChargebacksCollection();
		$this->each(function(ControversyChargebacks $controversyChargebacks) use ($idControversyReasons, $controversyChargebacksCollection){
			if( $controversyChargebacks->getIdControversyReasons() == $idControversyReasons)
				$controversyChargebacksCollection->append($controversyChargebacks);
		});
		
		return $controversyChargebacksCollection;
	}
	

}