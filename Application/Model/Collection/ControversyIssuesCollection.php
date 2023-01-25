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

use Application\Model\Bean\ControversyIssues;

/**
 *
 * ControversyIssuesCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ControversyIssues current()
 * @method \Application\Model\Bean\ControversyIssues read()
 * @method \Application\Model\Bean\ControversyIssues getOne()
 * @method \Application\Model\Bean\ControversyIssues getOneOrElse() getOneOrElse(Application\Model\Bean\ControversyIssues $controversyIssues)
 * @method \Application\Model\Bean\ControversyIssues getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\ControversyIssues getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\ControversyIssues $controversyIssues)
 * @method \Application\Model\Collection\ControversyIssuesCollection intersect() intersect(\Application\Model\Collection\ControversyIssuesCollection $collection)
 * @method \Application\Model\Collection\ControversyIssuesCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ControversyIssuesCollection merge() merge(\Application\Model\Collection\ControversyIssuesCollection $collection)
 * @method \Application\Model\Collection\ControversyIssuesCollection diff() diff(\Application\Model\Collection\ControversyIssuesCollection $collection)
 * @method \Application\Model\Collection\ControversyIssuesCollection copy()
 */
class ControversyIssuesCollection extends Collection{

    /**
     *
     * @param ControversyIssues $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ControversyIssues) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ControversyIssues");
        }
    }

    /**
     * @return array
     */
    public function toCombo($notNull = false){
        return ($notNull ? array() : array('')) + $this->map(function(ControversyIssues $controversyIssues){
            return array( $controversyIssues->getIdControversyIssue() => $controversyIssues->getName() );
        });
    }


	/**
	 * Returns an array with ids the ControversyReasons
	 * @return array
	 */
	public function getControversyReasonsIds()
	{
		return $this->map(function(ControversyIssues $controversyIssues){
			return array( $controversyIssues->getIdControversyReasons() => $controversyIssues->getIdControversyReasons() );
		});
	}
	
	/**
     *
     * @return \Application\Model\Collection\ControversyIssuesCollection
     */
	public function getByIdControversyReasons($idControversyReasons)
	{
		$controversyIssuesCollection = new ControversyIssuesCollection();
		$this->each(function(ControversyIssues $controversyIssues) use ($idControversyReasons, $controversyIssuesCollection){
			if( $controversyIssues->getIdControversyReasons() == $idControversyReasons)
				$controversyIssuesCollection->append($controversyIssues);
		});
		
		return $controversyIssuesCollection;
	}
	

}