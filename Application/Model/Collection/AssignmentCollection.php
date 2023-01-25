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

use Application\Model\Bean\Assignment;

/**
 *
 * AssignmentCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Assignment current()
 * @method \Application\Model\Bean\Assignment read()
 * @method \Application\Model\Bean\Assignment getOne()
 * @method \Application\Model\Bean\Assignment getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AssignmentCollection intersect() intersect(\Application\Model\Collection\AssignmentCollection $collection)
 * @method \Application\Model\Collection\AssignmentCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AssignmentCollection merge() merge(\Application\Model\Collection\AssignmentCollection $collection)
 * @method \Application\Model\Collection\AssignmentCollection diff() diff(\Application\Model\Collection\AssignmentCollection $collection)
 * @method \Application\Model\Collection\AssignmentCollection copy()
 */
class AssignmentCollection extends Collection{

    /**
     *
     * @param Assignment $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Assignment) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Assignment");
        }
    }
    /**
     * 
     * @return array
     */
	public function getFileIds(){
		return $this->map(function(Assignment $assignment){
			if ($assignment->getIdFile())
				return array($assignment->getIdFile() => $assignment->getIdFile());
		});
	}
        
        public function getFileResolutionIds(){
		return $this->map(function(Assignment $assignment){
			if ($assignment->getIdResolutionFile())
				return array($assignment->getIdResolutionFile() => $assignment->getIdResolutionFile());
		});
	}
}