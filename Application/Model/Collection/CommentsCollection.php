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

use Application\Model\Bean\Comments;

/**
 *
 * CommentsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Comments current()
 * @method \Application\Model\Bean\Comments read()
 * @method \Application\Model\Bean\Comments getOne()
 * @method \Application\Model\Bean\Comments getOneOrElse() getOneOrElse(Application\Model\Bean\Comments $comments)
 * @method \Application\Model\Bean\Comments getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\Comments getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\Comments $comments)
 * @method \Application\Model\Collection\CommentsCollection intersect() intersect(\Application\Model\Collection\CommentsCollection $collection)
 * @method \Application\Model\Collection\CommentsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CommentsCollection merge() merge(\Application\Model\Collection\CommentsCollection $collection)
 * @method \Application\Model\Collection\CommentsCollection diff() diff(\Application\Model\Collection\CommentsCollection $collection)
 * @method \Application\Model\Collection\CommentsCollection copy()
 */
class CommentsCollection extends Collection{

//    /**
//     *
//     * @param Comments $collectable
//     */
//    protected function validate($collectable)
//    {
//        if( !($collectable instanceof Comments) ){
//            throw new \InvalidArgumentException("Debe de ser un objecto Comments");
//        }
//    }
//
//
//
//	/**
//	 * Returns an array with ids the 
//	 * @return array
//	 */
//	public function getIds()
//	{
//		return $this->map(function(Comments $comments){
//			return array( $comments->getId() => $comments->getId() );
//		});
//	}
//	
//	/**
//     *
//     * @return \Application\Model\Collection\CommentsCollection
//     */
//	public function getById($id)
//	{
//		$commentsCollection = new CommentsCollection();
//		$this->each(function(Comments $comments) use ($id, $commentsCollection){
//			if( $comments->getId() == $id)
//				$commentsCollection->append($comments);
//		});
//		
//		return $commentsCollection;
//	}
//	
//	/**
//	 * Returns an array with ids the 
//	 * @return array
//	 */
//	public function getIds()
//	{
//		return $this->map(function(Comments $comments){
//			return array( $comments->getId() => $comments->getId() );
//		});
//	}
//	
//	/**
//     *
//     * @return \Application\Model\Collection\CommentsCollection
//     */
//	public function getById($id)
//	{
//		$commentsCollection = new CommentsCollection();
//		$this->each(function(Comments $comments) use ($id, $commentsCollection){
//			if( $comments->getId() == $id)
//				$commentsCollection->append($comments);
//		});
//		
//		return $commentsCollection;
//	}
//	
//	/**
//	 * Returns an array with ids the 
//	 * @return array
//	 */
//	public function getIds()
//	{
//		return $this->map(function(Comments $comments){
//			return array( $comments->getId() => $comments->getId() );
//		});
//	}
//	
//	/**
//     *
//     * @return \Application\Model\Collection\CommentsCollection
//     */
//	public function getById($id)
//	{
//		$commentsCollection = new CommentsCollection();
//		$this->each(function(Comments $comments) use ($id, $commentsCollection){
//			if( $comments->getId() == $id)
//				$commentsCollection->append($comments);
//		});
//		
//		return $commentsCollection;
//	}
//	
/**
     *
     * @param Reasons $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Comments) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Comments");
        }
    }

    /**
     * @return array
     */
    
    
    public function toCombo($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(Comments $comments){
    			return array( $comments->getIdReason() => $comments->getName() );
    		});
    		return $array;
    }
    
    /**
    * @return array
    */
    public function toComboConcat($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(Comments $comments){
    			return array( $comments->getIdReason().'-'.(int)$comments->getFinancialMovement().'-'.(int)$comments->getPartialities() => $comments->getName() );
    		});
    		return $array;
    }

}