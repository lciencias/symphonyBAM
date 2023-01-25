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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\UserGroup;
use Application\Model\Factory\UserGroupFactory;
use Application\Model\Collection\UserGroupCollection;
use Application\Model\Exception\UserGroupException;
use Application\Model\Bean\Bean;
use Application\Query\UserGroupQuery;
use Query\Query;

/**
 *
 * UserGroupCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\UserGroup getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\UserGroupCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class UserGroupCatalog extends AbstractCatalog {

	
	public function create($userGroup){
		
	}

	public function update($userGroup){
		
	}
	public function deleteById($idUserGroup){
		
	}
	/**
	 *
	 * makeCollection
	 * @return \Application\Model\Collection\UserGroupCollection
	 */
	protected function makeCollection(){
		return new UserGroupCollection();
	}
	
	/**
	 *
	 * makeBean
	 * @param array $resultset
	 * @return \Application\Model\Bean\UserGroup
	 */
	protected function makeBean($resultset){
		return UserGroupFactory::createFromArray($resultset);
	}
	
	/**
	 *
	 * Validate Query
	 * @param UserLogQuery $query
	 * @throws RoundException
	 */
	protected function validateQuery(Query $query)
	{
		if( !($query instanceof UserGroupQuery) ){
			$this->throwException("No es un Query valido");
		}
	}
	
	/**
	 *
	 * Validate UserLog
	 * @param UserLog $userLog
	 * @throws Exception
	 */
	protected function validateBean($userLog = null){
		if( !($userLog instanceof UserGroup) ){
			$this->throwException("passed parameter isn't a UserGroup instance");
		}
	}
	
	/**
	 *
	 * throwException
	 * @throws Exception
	 */
	protected function throwException($message, \Exception $exception = null){
		if( null != $exception){
			throw new UserGroupException("$message ". $exception->getMessage(), 500, $exception);
		}else{
			throw new UserGroupException($message);
		}
	}
	

 }