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
use Application\Model\Catalog\CategoryLogCatalog;
use Application\Model\Bean\CategoryLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\CategoryLogQuery
 *
 * @method \Application\Query\CategoryLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CategoryLogQuery useMemoryCache()
 * @method \Application\Query\CategoryLogQuery useFileCache()
 * @method \Application\Model\Collection\CategoryLogCollection find()
 * @method \Application\Model\Bean\CategoryLog findOne()
 * @method \Application\Model\Bean\CategoryLog findOneOrElse() findOneOrElse(CategoryLog $alternative)
 * @method \Application\Model\Bean\CategoryLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\CategoryLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\CategoryLog findByPKOrElse() findByPKOrElse($pk, CategoryLog $alternative)
 * @method \Application\Model\Bean\CategoryLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CategoryLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CategoryLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CategoryLogQuery removeJoins()
 * @method \Application\Query\CategoryLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CategoryLogQuery from() from($table, $alias = null)
 * @method \Application\Query\CategoryLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CategoryLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CategoryLogQuery bind() bind($parameters)
 * @method \Application\Query\CategoryLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CategoryLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CategoryLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\CategoryLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\CategoryLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CategoryLogQuery distinct()
 * @method \Application\Query\CategoryLogQuery select()
 * @method \Application\Query\CategoryLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\CategoryLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CategoryLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CategoryLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CategoryLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CategoryLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CategoryLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CategoryLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CategoryLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CategoryLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CategoryLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(CategoryLog::TABLENAME, "CategoryLog");

        $defaultColumn = array("CategoryLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\CategoryLogQuery
     */
    public function pk($value){
        $this->filter(array(
            CategoryLog::ID_CATEGORY_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(CategoryLog::ID_CATEGORY_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CategoryLogQuery
     */
    public function filter($fields, $prefix = 'CategoryLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'CategoryLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_category_log']) && !empty($fields['id_category_log']) ){
            $criteria->add(CategoryLog::ID_CATEGORY_LOG, $fields['id_category_log']);
        }
        if( isset($fields['id_category']) && !empty($fields['id_category']) ){
            $criteria->add(CategoryLog::ID_CATEGORY, $fields['id_category']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(CategoryLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(CategoryLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(CategoryLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(CategoryLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryLogQuery
     */
    public function innerJoinCategory($alias = 'CategoryLog', $aliasForeignTable = 'Category')
    {
        $this->innerJoinOn(\Application\Model\Bean\Category::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_category'), array($aliasForeignTable, 'id_category'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryLogQuery
     */
    public function innerJoinUser($alias = 'CategoryLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}