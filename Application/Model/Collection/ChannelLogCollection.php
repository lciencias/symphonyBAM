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

use Application\Model\Bean\ChannelLog;

/**
 *
 * ChannelLogCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\ChannelLog current()
 * @method \Application\Model\Bean\ChannelLog read()
 * @method \Application\Model\Bean\ChannelLog getOne()
 * @method \Application\Model\Bean\ChannelLog getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ChannelLogCollection intersect() intersect(\Application\Model\Collection\ChannelLogCollection $collection)
 * @method \Application\Model\Collection\ChannelLogCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ChannelLogCollection merge() merge(\Application\Model\Collection\ChannelLogCollection $collection)
 * @method \Application\Model\Collection\ChannelLogCollection diff() diff(\Application\Model\Collection\ChannelLogCollection $collection)
 * @method \Application\Model\Collection\ChannelLogCollection copy()
 */
class ChannelLogCollection extends Collection{

    /**
     *
     * @param ChannelLog $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ChannelLog) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ChannelLog");
        }
    }

    /**
     * @return array
     */
    public function getUserIds(){
        return $this->map(function($log){
            return array($log->getIdUser() => $log->getIdUser());
        });
    }

}