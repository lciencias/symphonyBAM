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

use Application\Model\Bean\CountryState;

/**
 *
 * CountryStateCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\CountryState current()
 * @method \Application\Model\Bean\CountryState read()
 * @method \Application\Model\Bean\CountryState getOne()
 * @method \Application\Model\Bean\CountryState getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CountryStateCollection intersect() intersect(\Application\Model\Collection\CountryStateCollection $collection)
 * @method \Application\Model\Collection\CountryStateCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CountryStateCollection merge() merge(\Application\Model\Collection\CountryStateCollection $collection)
 * @method \Application\Model\Collection\CountryStateCollection diff() diff(\Application\Model\Collection\CountryStateCollection $collection)
 * @method \Application\Model\Collection\CountryStateCollection copy()
 */
class CountryStateCollection extends Collection{

    /**
     *
     * @param CountryState $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof CountryState) ){
            throw new \InvalidArgumentException("Debe de ser un objecto CountryState");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
        $array += $this->map(function(CountryState $countryState){
            return array( $countryState->getIdCountryState() => $countryState->getName() );
        });
        return $array;
    }

}