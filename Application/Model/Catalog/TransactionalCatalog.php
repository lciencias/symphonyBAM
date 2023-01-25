<?php
/**
 * Bender
 *
 * Example Project created by Bender Code Generator
 *
 * @copyright Copyright (c) 2012 Bender (https://github.com/chentepixtol/Bender2)
 * @author    chente, $LastChangedBy$
 * @version   1
 */

namespace Application\Model\Catalog;

use Application\Base\Singleton;

/**
 *
 * TransactionalCatalog
 *
 * @category Application\Model\Catalog
 * @author chente
 */
class TransactionalCatalog extends Singleton
{

    /**
     * Engines
     * @var array
     */
    protected static $engines = array("pgsql", "mysql");

    /**
     * The current transaction level
     */
    protected static $transLevel = 0;

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function getDb()
    {
        return \Application\Database\DBAO::getDbAdapter();
    }

    /**
     * Soporta transacciones nested
     * @return array
     */
    protected function isNestable()
    {
        $engineName = $this->getDb()->getConnection()->getAttribute(\PDO::ATTR_DRIVER_NAME); 
        return in_array($engineName, self::$engines);
    }

    /**
     * beginTransaction
     */
    public function beginTransaction()
    {
        if( !$this->isNestable() || self::$transLevel == 0 ){
            $this->getDb()->beginTransaction();
        }else{
            $this->getDb()->exec("SAVEPOINT LEVEL".self::$transLevel);
        }
        self::$transLevel++;
    }

    /**
     * commit
     */
    public function commit()
    {
        self::$transLevel--;

        if( !$this->isNestable() || self::$transLevel == 0 ){
            $this->getDb()->commit();
        }else{
            $this->getDb()->exec("RELEASE SAVEPOINT LEVEL".self::$transLevel);
        }
    }

    /**
     * rollBack
     */
    public function rollBack()
    {
        self::$transLevel--;

        if( !$this->isNestable() || self::$transLevel == 0 ){
            $this->getDb()->rollBack();
        }else{
            $this->getDb()->exec("ROLLBACK TO SAVEPOINT LEVEL".self::$transLevel);
        }
    }
    
}
