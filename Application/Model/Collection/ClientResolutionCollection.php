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

use Application\Model\Bean\ClientResolution;

/**
 *
 * ClientResolutionCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientResolution current()
 * @method \Application\Model\Bean\ClientResolution read()
 * @method \Application\Model\Bean\ClientResolution getOne()
 * @method \Application\Model\Bean\ClientResolution getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientResolutionCollection intersect() intersect(\Application\Model\Collection\ClientResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientResolutionCollection merge() merge(\Application\Model\Collection\ClientResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionCollection diff() diff(\Application\Model\Collection\ClientResolutionCollection $collection)
 * @method \Application\Model\Collection\ClientResolutionCollection copy()
 */
class ClientResolutionCollection extends Collection{

    /**
     *
     * @param ClientResolution $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientResolution) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientResolution");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(ClientResolution $clientResolution){
            return array( $clientResolution->getIdClientResolution() => $clientResolution->getName() );
        });
    }
    
    public function toComboA($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(ClientResolution $clientResolution){
    			return array( $clientResolution->getIdClientResolution() => $clientResolution->getName() );
    		});
    	return $array;
    }
    
    public function toComboType(){
    	return $this->map(function(ClientResolution $clientResolution){
    		return array( $clientResolution->getIdClientResolution() => $clientResolution->getType() );
    	});
    }
    
}