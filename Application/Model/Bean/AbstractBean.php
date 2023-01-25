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
 * AbstractBean
 *
 * @category Application\Model\Bean
 * @author 
 */
abstract class AbstractBean implements Bean
{

    /**
     * Convert to array
     * @return array
     */
    public function toArrayFor($fields){
        $array = array();
        $all = $this->toArray();
        foreach($fields as $field){
            if( array_key_exists($field, $all) ){
                $array[$field] = $all[$field];
            }
        }
        return $array;
    }

    
    public function format($fecha){
    	$date = date_create($fecha);
    	return date_format($date, 'Y-m-d H:i:s');
    	 
    }
}
