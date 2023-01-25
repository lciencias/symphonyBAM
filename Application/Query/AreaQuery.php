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
use Application\Model\Catalog\AreaCatalog;
use Application\Model\Bean\Area;

use Application\Query\BaseQuery;

/**
 * Application\Query\AreaQuery
 *
 * @method \Application\Query\AreaQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AreaQuery useMemoryCache()
 * @method \Application\Query\AreaQuery useFileCache()
 * @method \Application\Model\Collection\AreaCollection find()
 * @method \Application\Model\Bean\Area findOne()
 * @method \Application\Model\Bean\Area findOneOrElse() findOneOrElse(Area $alternative)
 * @method \Application\Model\Bean\Area findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Area findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Area findByPKOrElse() findByPKOrElse($pk, Area $alternative)
 * @method \Application\Model\Bean\Area findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AreaQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AreaQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AreaQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AreaQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AreaQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AreaQuery removeJoins()
 * @method \Application\Query\AreaQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AreaQuery from() from($table, $alias = null)
 * @method \Application\Query\AreaQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AreaQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AreaQuery bind() bind($parameters)
 * @method \Application\Query\AreaQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AreaQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AreaQuery setLimit() setLimit($limit)
 * @method \Application\Query\AreaQuery setOffset() setOffset($offset)
 * @method \Application\Query\AreaQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AreaQuery distinct()
 * @method \Application\Query\AreaQuery select()
 * @method \Application\Query\AreaQuery addColumns() addColumns($columns)
 * @method \Application\Query\AreaQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AreaQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AreaQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AreaQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AreaQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AreaQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AreaQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AreaQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AreaCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AreaCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Area::TABLENAME, "Area");

        $defaultColumn = array("Area.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\AreaQuery
     */
    public function pk($value){
        $this->filter(array(
            Area::ID_AREA => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Area::ID_AREA, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AreaQuery
     */
    public function filter($fields, $prefix = 'Area'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Area')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_area']) && !empty($fields['id_area']) ){
            $criteria->add(Area::ID_AREA, $fields['id_area']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Area::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Area::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Area::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\AreaQuery
     */
    public function actives(){
        return $this->filter(array(
            Area::STATUS => Area::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\AreaQuery
     */
    public function inactives(){
        return $this->filter(array(
            Area::STATUS => Area::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AreaQuery
     */
    public function innerJoinCompany($alias = 'Area', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }


}