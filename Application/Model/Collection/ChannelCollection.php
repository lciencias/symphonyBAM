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

use Application\Model\Bean\Channel;

/**
 *
 * ChannelCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Channel current()
 * @method \Application\Model\Bean\Channel read()
 * @method \Application\Model\Bean\Channel getOne()
 * @method \Application\Model\Bean\Channel getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ChannelCollection intersect() intersect(\Application\Model\Collection\ChannelCollection $collection)
 * @method \Application\Model\Collection\ChannelCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ChannelCollection merge() merge(\Application\Model\Collection\ChannelCollection $collection)
 * @method \Application\Model\Collection\ChannelCollection diff() diff(\Application\Model\Collection\ChannelCollection $collection)
 * @method \Application\Model\Collection\ChannelCollection copy()
 */
class ChannelCollection extends Collection{

    /**
     *
     * @param Channel $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Channel) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Channel");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
        $array += $this->map(function(Channel $channel){
            return array( $channel->getIdChannel() => $channel->getName() );
        });
        return $array;
    }

    /**
     *
     * @return \Application\Model\Collection\ChannelCollection
     */
    public function actives(){
        return $this->filter(function(Channel $channel){
            return $channel->isActive();
        });
    }

}