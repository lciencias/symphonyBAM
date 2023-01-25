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

use Query\Query;
use Application\Model\Catalog\CategoryCatalog;
use Application\Model\Bean\Category;

use Application\Query\BaseQuery;

/**
 * Application\Query\CategoryQuery
 *
 * @method \Application\Query\CategoryQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CategoryQuery useMemoryCache()
 * @method \Application\Query\CategoryQuery useFileCache()
 * @method \Application\Model\Collection\CategoryCollection find()
 * @method \Application\Model\Bean\Category findOne()
 * @method \Application\Model\Bean\Category findOneOrElse() findOneOrElse(Category $alternative)
 * @method \Application\Model\Bean\Category findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Category findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Category findByPKOrElse() findByPKOrElse($pk, Category $alternative)
 * @method \Application\Model\Bean\Category findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CategoryQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CategoryQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CategoryQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CategoryQuery removeJoins()
 * @method \Application\Query\CategoryQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CategoryQuery from() from($table, $alias = null)
 * @method \Application\Query\CategoryQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CategoryQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CategoryQuery bind() bind($parameters)
 * @method \Application\Query\CategoryQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CategoryQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CategoryQuery setLimit() setLimit($limit)
 * @method \Application\Query\CategoryQuery setOffset() setOffset($offset)
 * @method \Application\Query\CategoryQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CategoryQuery distinct()
 * @method \Application\Query\CategoryQuery select()
 * @method \Application\Query\CategoryQuery addColumns() addColumns($columns)
 * @method \Application\Query\CategoryQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CategoryQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CategoryQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CategoryQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CategoryQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CategoryQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CategoryQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CategoryQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CategoryCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CategoryCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Category::TABLENAME, "Category");

        $defaultColumn = array("Category.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\CategoryQuery
     */
    public function pk($value){
        $this->filter(array(
            Category::ID_CATEGORY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Category::ID_CATEGORY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CategoryQuery
     */
    public function filter($fields, $prefix = 'Category'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Category')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_category']) && !empty($fields['id_category']) ){
            $criteria->add(Category::ID_CATEGORY, $fields['id_category']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Category::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['id_group']) && !empty($fields['id_group']) ){
            $criteria->add(Category::ID_GROUP, $fields['id_group']);
        }
        if( isset($fields['id_escalation']) && !empty($fields['id_escalation']) ){
            $criteria->add(Category::ID_ESCALATION, $fields['id_escalation']);
        }
        if( isset($fields['id_service_level']) && !empty($fields['id_service_level']) ){
            $criteria->add(Category::ID_SERVICE_LEVEL, $fields['id_service_level']);
        }
        if( isset($fields['id_parent']) && !empty($fields['id_parent']) ){
            $criteria->add(Category::ID_PARENT, $fields['id_parent']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Category::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Category::STATUS, $fields['status']);
        }
        if( isset($fields['is_leaf']) && !empty($fields['is_leaf']) ){
            $criteria->add(Category::IS_LEAF, $fields['is_leaf']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(Category::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\CategoryQuery
     */
    public function actives(){
        return $this->filter(array(
            Category::STATUS => Category::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\CategoryQuery
     */
    public function inactives(){
        return $this->filter(array(
            Category::STATUS => Category::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryQuery
     */
    public function innerJoinCompany($alias = 'Category', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryQuery
     */
    public function innerJoinGroup($alias = 'Category', $aliasForeignTable = 'Group')
    {
        $this->innerJoinOn(\Application\Model\Bean\Group::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_group'), array($aliasForeignTable, 'id_group'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryQuery
     */
    public function innerJoinEscalation($alias = 'Category', $aliasForeignTable = 'Escalation')
    {
        $this->innerJoinOn(\Application\Model\Bean\Escalation::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_escalation'), array($aliasForeignTable, 'id_escalation'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryQuery
     */
    public function innerJoinServiceLevel($alias = 'Category', $aliasForeignTable = 'ServiceLevel')
    {
        $this->innerJoinOn(\Application\Model\Bean\ServiceLevel::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_service_level'), array($aliasForeignTable, 'id_service_level'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CategoryQuery
     */
    public function innerJoinCategory($alias = 'Category', $aliasForeignTable = 'Category')
    {
        $this->innerJoinOn(\Application\Model\Bean\Category::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_parent'), array($aliasForeignTable, 'id_category'));

        return $this;
    }


}