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
use Application\Model\Catalog\LocationCatalog;
use Application\Model\Bean\Location;

use Application\Query\BaseQuery;

/**
 * Application\Query\LocationQuery
 *
 * @method \Application\Query\LocationQuery pk() pk(int $primaryKey)
 * @method \Application\Query\LocationQuery useMemoryCache()
 * @method \Application\Query\LocationQuery useFileCache()
 * @method \Application\Model\Collection\LocationCollection find()
 * @method \Application\Model\Bean\Location findOne()
 * @method \Application\Model\Bean\Location findOneOrElse() findOneOrElse(Location $alternative)
 * @method \Application\Model\Bean\Location findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Location findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Location findByPKOrElse() findByPKOrElse($pk, Location $alternative)
 * @method \Application\Model\Bean\Location findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\LocationQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\LocationQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\LocationQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\LocationQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\LocationQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\LocationQuery removeJoins()
 * @method \Application\Query\LocationQuery removeJoin() removeJoin($table)
 * @method \Application\Query\LocationQuery from() from($table, $alias = null)
 * @method \Application\Query\LocationQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\LocationQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\LocationQuery bind() bind($parameters)
 * @method \Application\Query\LocationQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\LocationQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\LocationQuery setLimit() setLimit($limit)
 * @method \Application\Query\LocationQuery setOffset() setOffset($offset)
 * @method \Application\Query\LocationQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\LocationQuery distinct()
 * @method \Application\Query\LocationQuery select()
 * @method \Application\Query\LocationQuery addColumns() addColumns($columns)
 * @method \Application\Query\LocationQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\LocationQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\LocationQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\LocationQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\LocationQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\LocationQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\LocationQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class LocationQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\LocationCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('LocationCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Location::TABLENAME, "Location");

        $defaultColumn = array("Location.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\LocationQuery
     */
    public function pk($value){
        $this->filter(array(
            Location::ID_LOCATION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Location::ID_LOCATION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\LocationQuery
     */
    public function filter($fields, $prefix = 'Location'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Location')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_location']) && !empty($fields['id_location']) ){
            $criteria->add(Location::ID_LOCATION, $fields['id_location']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Location::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Location::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Location::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\LocationQuery
     */
    public function actives(){
        return $this->filter(array(
            Location::STATUS => Location::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\LocationQuery
     */
    public function inactives(){
        return $this->filter(array(
            Location::STATUS => Location::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\LocationQuery
     */
    public function innerJoinCompany($alias = 'Location', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }


}