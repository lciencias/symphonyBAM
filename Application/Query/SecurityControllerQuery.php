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

use Query\Query;
use Application\Model\Catalog\SecurityControllerCatalog;
use Application\Model\Bean\SecurityController;

use Application\Query\BaseQuery;

/**
 * Application\Query\SecurityControllerQuery
 *
 * @method \Application\Query\SecurityControllerQuery pk() pk(int $primaryKey)
 * @method \Application\Query\SecurityControllerQuery useMemoryCache()
 * @method \Application\Query\SecurityControllerQuery useFileCache()
 * @method \Application\Model\Collection\SecurityControllerCollection find()
 * @method \Application\Model\Bean\SecurityController findOne()
 * @method \Application\Model\Bean\SecurityController findOneOrElse() findOneOrElse(SecurityController $alternative)
 * @method \Application\Model\Bean\SecurityController findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\SecurityController findByPK() findByPK($pk)
 * @method \Application\Model\Bean\SecurityController findByPKOrElse() findByPKOrElse($pk, SecurityController $alternative)
 * @method \Application\Model\Bean\SecurityController findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\SecurityControllerQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\SecurityControllerQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityControllerQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityControllerQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityControllerQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\SecurityControllerQuery removeJoins()
 * @method \Application\Query\SecurityControllerQuery removeJoin() removeJoin($table)
 * @method \Application\Query\SecurityControllerQuery from() from($table, $alias = null)
 * @method \Application\Query\SecurityControllerQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\SecurityControllerQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\SecurityControllerQuery bind() bind($parameters)
 * @method \Application\Query\SecurityControllerQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\SecurityControllerQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\SecurityControllerQuery setLimit() setLimit($limit)
 * @method \Application\Query\SecurityControllerQuery setOffset() setOffset($offset)
 * @method \Application\Query\SecurityControllerQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\SecurityControllerQuery distinct()
 * @method \Application\Query\SecurityControllerQuery select()
 * @method \Application\Query\SecurityControllerQuery addColumns() addColumns($columns)
 * @method \Application\Query\SecurityControllerQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\SecurityControllerQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\SecurityControllerQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\SecurityControllerQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\SecurityControllerQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\SecurityControllerQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\SecurityControllerQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class SecurityControllerQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\SecurityControllerCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('SecurityControllerCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(SecurityController::TABLENAME, "SecurityController");

        $defaultColumn = array("SecurityController.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\SecurityControllerQuery
     */
    public function pk($value){
        $this->filter(array(
            SecurityController::ID_CONTROLLER => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(SecurityController::ID_CONTROLLER, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\SecurityControllerQuery
     */
    public function filter($fields, $prefix = 'SecurityController'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'SecurityController')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_controller']) && !empty($fields['id_controller']) ){
            $criteria->add(SecurityController::ID_CONTROLLER, $fields['id_controller']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(SecurityController::NAME, $fields['name']);
        }

        $criteria->endPrefix();
    }


}