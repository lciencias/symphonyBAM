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

namespace Application\Database;

use Zend_Db as ZendDb;

/**
 *
 * DBAO
 *
 * @category Application\Database
 * @author guadalupe, chente
 */
class DBAOFromConfig implements DBAO
{

    /**
     * @var \Zend_Db_Adapter_Abstract
     */
    protected $dbAdapter  = null;

    /**
     * @param Config
     */
    public function __construct($dbConfig){
        $this->dbAdapter = ZendDb::factory($dbConfig->database);
    }

    /**
     * Metodo para obtener la Connection
     * @return \Zend_Db_Adapter_Abstract
     */
    public function getDbAdapter(){
        return $this->dbAdapter;
    }

}