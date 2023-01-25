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

use Application\Model\Bean\Branch;

/**
 *
 * BranchCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Branch current()
 * @method \Application\Model\Bean\Branch read()
 * @method \Application\Model\Bean\Branch getOne()
 * @method \Application\Model\Bean\Branch getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\BranchCollection intersect() intersect(\Application\Model\Collection\BranchCollection $collection)
 * @method \Application\Model\Collection\BranchCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\BranchCollection merge() merge(\Application\Model\Collection\BranchCollection $collection)
 * @method \Application\Model\Collection\BranchCollection diff() diff(\Application\Model\Collection\BranchCollection $collection)
 * @method \Application\Model\Collection\BranchCollection copy()
 */
class BranchCollection extends Collection{

    /**
     *
     * @param Branch $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Branch) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Branch");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    	$array += $this->map(function(Branch $branch){
            return array( $branch->getIdBranch() => $branch->getName() );
        });
        return $array;
    }

}