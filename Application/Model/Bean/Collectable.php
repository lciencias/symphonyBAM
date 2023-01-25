<?php
/**
 * 
 *
 * 
 *
 * @copyright 
 * @author    , $LastChangedBy$
 * @version   
 */

namespace Application\Model\Bean;

/**
 *
 * Collectable
 *
 * @category Application\Model\Bean
 * @author 
 */
interface Collectable
{

    /**
     *
     * @return int
     */
    public function getIndex();

    /**
     * Convert to array
     * @return array
     */
    public function toArray();

    /**
     * Convert to array
     * @return array
     */
    public function toArrayFor($fields);


}
