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



namespace Application\Query;

use Application\Storage\StorageFactory;

use Query\ZendDbQuoteStrategy;

use Query\QuoteStrategy;

use Query\Query;
use Application\Storage\Storage;
use Application\Base\Option;

/**
 *
 *
 * @author chente
 * @abstract
 */
abstract class BaseQuery extends Query
{

    /**
     *
     */
    protected $storage = null;

    /**
     *
     * @var Strategy
     */
    private static $zendDbStrategy = null;

    /**
     * Esta variable se usa para reescribir el paginador (cambio de sintaxis de MYSQL a SQLServer)
     *
     * @var int
     */
    protected $pageOffset = null;
    
    /**
     * Esta variable se usa para reescribir el paginador (cambio de sintaxis de MYSQL a SQLServer)
     *
     * @var int
     */
    protected $pageFetch = null;
    
    
    /**
     * @abstract
     * @return \Application\Model\Catalog\Catalog
     */
    abstract protected function getCatalog();

    /**
     * @abstract
     * @return BaseQuery
     */
    abstract public function pk($primaryKey);

    /**
     * @abstract
     * @return array
     */
    abstract public function fetchIds();

    /**
     *
     * @param QuoteStrategy $quoteStrategy
     */
    public function __construct(QuoteStrategy $quoteStrategy = null){
        if( $quoteStrategy == null ){
            $quoteStrategy = self::getZendDbQuoteStrategy();
        }
        parent::__construct($quoteStrategy);
    }

    /**
     *
     */
    public static function getZendDbQuoteStrategy(){
        if( null == self::$zendDbStrategy ){
            self::$zendDbStrategy = new ZendDbQuoteStrategy(self::getDBAdapter());
        }
        return self::$zendDbStrategy;
    }

    /**
     *
     */
    private static function getDBAdapter(){
        return \Zend_Registry::get('container')->get('dbao')->getDbAdapter();
    }

    /**
     * @return BaseQuery
     */
    public function useMemoryCache(){
       $this->setStorage(\Application\Storage\StorageFactory::create('memory'));
       return $this;
    }

    /**
     * @return BaseQuery
     */
    public function notCache(){
        $this->setStorage(\Application\Storage\StorageFactory::create('null'));
        return $this;
    }

    /**
     * @return BaseQuery
     */
    public function useFileCache(){
       $this->setStorage(\Application\Storage\StorageFactory::create('file'));
       return $this;
    }

    /**
     *
     * @return \Application\Model\Collection\Collection
     */
    public function find(){
        return $this->getCatalog()->getByQuery($this, $this->getStorage());
    }

    /**
     *
     * @return \Application\Model\Bean\Bean
     */
    public function findOne(){
        return $this->getCatalog()->getOneByQuery($this, $this->getStorage());
    }

    /**
     * @param mixed $pk
     * @return \Application\Model\Bean\Bean
     */
    public function findByPK($pk){
        $this->validatePK($pk);
        return $this->pk($pk)->findOne();
    }

    /**
     * @return int
     */
    public function count($field = '*'){
       $this->addColumn($field, 'count', Query::COUNT);
       return (int) $this->fetchOne();
    }

    /**
     * @return \Application\Base\Option
     */
    public function findOneOption(){
        return new Option($this->findOne());
    }

    /**
     * @param mixed $alternative
     * @return \Application\Model\Bean\Bean
     */
    public function findOneOrElse($alternative){
        return $this->findOneOption()->getOrElse($alternative);
    }

    /**
     * @param mixed $message
     * @return \Application\Model\Bean\Bean
     * @throws \UnexpectedValueException
     */
    public function findOneOrThrow($message){
        return $this->findOneOption()->getOrThrow($message);
    }

    /**
     * @param mixed $pk
     * @return \Application\Base\Option
     */
    public function findOptionByPK($pk){
        $this->validatePK($pk);
        return $this->pk($pk)->findOneOption();
    }

    /**
     * @param mixed $pk
     * @param mixed $alternative
     * @return \Application\Model\Bean\Bean
     */
    public function findByPKOrElse($pk, $alternative){
        return $this->findOptionByPK($pk)->getOrElse($alternative);
    }

    /**
     * @param mixed $pk
     * @param mixed $message
     * @return \Application\Model\Bean\Bean
     * @throws \UnexpectedValueException
     */
    public function findByPKOrThrow($pk, $message){
        return $this->findOptionByPK($pk)->getOrThrow($message);
    }

    /**
     *
     * @return array
     */
    public function fetchCol(){
        return $this->getCatalog()->fetchCol($this, $this->getStorage());
    }

    /**
     *
     * @return array
     */
    public function fetchAll(){
        return $this->getCatalog()->fetchAll($this, $this->getStorage());
    }

    /**
     *
     * @return mixed
     */
    public function fetchOne(){
        return $this->getCatalog()->fetchOne($this, $this->getStorage());
    }

    /**
     *
     * @return array
     */
    public function fetchPairs(){
        return $this->getCatalog()->fetchPairs($this, $this->getStorage());
    }

    /**
     * @param Storage $storage
     * @return BaseQuery
     */
    public function setStorage(Storage $storage){
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return \Application\Storage\Storage
     */
    public function getStorage(){
        return $this->storage;
    }

    /**
     * @param mixed $pk
     */
    private function validatePK($pk){
        if( empty($pk) ){
            throw new \Exception("No es proporcionada la llave primaria");
        }
    }
    
    /*******************ESTAS LINEAS SE AÑADIERON PARA EL PAGINADOR DE MSSQL **********************/
    
    /**
     * (non-PHPdoc)
     * @see Query.ManipulationStatement::page()
     */
    public function page($page, $itemsPerPage)
    {
    	$this->setPageOffset(($page-1) * $itemsPerPage);
    	$this->setPageFetch($itemsPerPage);
    	return $this;
    }
    
    /**
     * @param int $pageOffset
     */
    public function setPageOffset($pageOffset)
    {
    	$this->pageOffset = $pageOffset;
    }
    
    /**
     * @param int $pageOffset
     */
    public function setPageFetch($pageFetch)
    {
    	$this->pageFetch = $pageFetch;
    }
    
    /**
     *
     * @return number
     */
    public function getPageOffset()
    {
    	return $this->pageOffset;
    }
    
    /**
     *
     * @return number
     */
    public function getPageFetch()
    {
    	return $this->pageFetch;
    }
    
    /**
     *
     * @return string
     */
    public function createOffsetSql()
    {
    	$sql = '';
    	if ($this->getPageOffset() !== null && $this->getPageFetch() !== null) {
    		$sql .= "OFFSET " . $this->getPageOffset() . " ROWS FETCH NEXT " . $this->getPageFetch() . " ROWS ONLY";
    	}
    	return $sql;
    }
    
    /** (non-PHPdoc)
     * @see Criterion::createSql()
     */
	public function createSql()
    {
    	if (!$this->createOrderSql() && $this->createOffsetSql()) {
    		$this->addAscendingOrderBy("1");
    	}    	 
    	$parts = array(
    			$this->createSelectSql(),
    			$this->createFromSql(),
    			$this->createJoinSql(),
    			$this->createWhereSql(),
    			$this->createGroupSql(),
    			$this->createHavingSql(),
    			$this->createOrderSql(),
    			$this->createOffsetSql(),
    			$this->createIntoSql()
    	);
    
    	$sql = implode(' ', array_filter($parts));		
    	return  $this->replaceParameters($sql);
    }
        
    
}