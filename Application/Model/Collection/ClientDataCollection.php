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

use Application\Model\Bean\ClientData;

/**
 *
 * ClientDataCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientData current()
 * @method \Application\Model\Bean\ClientData read()
 * @method \Application\Model\Bean\ClientData getOne()
 * @method \Application\Model\Bean\ClientData getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientDataCollection intersect() intersect(\Application\Model\Collection\ClientDataCollection $collection)
 * @method \Application\Model\Collection\ClientDataCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientDataCollection merge() merge(\Application\Model\Collection\ClientDataCollection $collection)
 * @method \Application\Model\Collection\ClientDataCollection diff() diff(\Application\Model\Collection\ClientDataCollection $collection)
 * @method \Application\Model\Collection\ClientDataCollection copy()
 */
class ClientDataCollection extends Collection{

    /**
     *
     * @param ClientData $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientData) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientData");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(ClientData $clientData){
            return array( $clientData->getIndex() => $clientData->getName() );
        });
    }

}