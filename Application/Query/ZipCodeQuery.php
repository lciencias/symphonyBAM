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

namespace Application\Query;

use Query\Query;
use Application\Model\Catalog\ZipCodeCatalog;
use Application\Model\Bean\ZipCode;

use Application\Query\BaseQuery;

/**
 * ZipCodeQuery
 *
 * @method ZipCodeQuery pk() pk(int $primaryKey)
 * @method ZipCodeQuery useMemoryCache()
 * @method ZipCodeQuery useFileCache()
 * @method \Application\Model\Collection\ZipCodeCollection find()
 * @method \Application\Model\Bean\ZipCode findOne()
 * @method \Application\Model\Bean\ZipCode findOneOrElse() findOneOrElse(ZipCode $alternative)
 * @method \Application\Model\Bean\ZipCode findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ZipCode findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ZipCode findByPKOrElse() findByPKOrElse($pk, ZipCode $alternative)
 * @method \Application\Model\Bean\ZipCode findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method ZipCodeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method ZipCodeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method ZipCodeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method ZipCodeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method ZipCodeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method ZipCodeQuery removeJoins()
 * @method ZipCodeQuery removeJoin() removeJoin($table)
 * @method ZipCodeQuery from() from($table, $alias = null)
 * @method ZipCodeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method ZipCodeQuery whereAdd() $column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method ZipCodeQuery bind() bind($parameters)
 * @method ZipCodeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method ZipCodeQuery page() page($page, $itemsPerPage)
 * @method ZipCodeQuery setLimit() setLimit($limit)
 * @method ZipCodeQuery setOffset() setOffset($offset)
 * @method ZipCodeQuery removeColumn() removeColumn($column = null)
 * @method ZipCodeQuery distinct()
 * @method ZipCodeQuery select()
 * @method ZipCodeQuery addColumns() addColumns($columns)
 * @method ZipCodeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method ZipCodeQuery addGroupBy() addGroupBy($groupBy)
 * @method ZipCodeQuery orderBy() orderBy($name, $type = null)
 * @method ZipCodeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method ZipCodeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method ZipCodeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method ZipCodeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ZipCodeQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ZipCodeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ZipCodeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ZipCode::TABLENAME, "ZipCode");

        $defaultColumn = array("ZipCode.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return ZipCodeQuery
     */
    public function pk($value){
        $this->filter(array(
            ZipCode::ID_ZIP_CODE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ZipCode::ID_ZIP_CODE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return ZipCodeQuery
     */
    public function filter($fields, $prefix = 'ZipCode'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ZipCode')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_zip_code']) && !empty($fields['id_zip_code']) ){
            $criteria->add(ZipCode::ID_ZIP_CODE, $fields['id_zip_code']);
        }
        if( isset($fields['zip_code']) && !empty($fields['zip_code']) ){
            $criteria->add(ZipCode::ZIP_CODE, $fields['zip_code']);
        }
        if( isset($fields['settlement']) && !empty($fields['settlement']) ){
            $criteria->add(ZipCode::SETTLEMENT, $fields['settlement']);
        }
        if( isset($fields['settlement_type']) && !empty($fields['settlement_type']) ){
            $criteria->add(ZipCode::SETTLEMENT_TYPE, $fields['settlement_type']);
        }
        if( isset($fields['district']) && !empty($fields['district']) ){
            $criteria->add(ZipCode::DISTRICT, $fields['district']);
        }
        if( isset($fields['state']) && !empty($fields['state']) ){
            $criteria->add(ZipCode::STATE, $fields['state']);
        }
        if( isset($fields['city']) && !empty($fields['city']) ){
            $criteria->add(ZipCode::CITY, $fields['city']);
        }
        if( isset($fields['d_cp']) && !empty($fields['d_cp']) ){
            $criteria->add(ZipCode::D_CP, $fields['d_cp']);
        }
        if( isset($fields['id_mexico_state']) && !empty($fields['id_mexico_state']) ){
            $criteria->add(ZipCode::ID_MEXICO_STATE, $fields['id_mexico_state']);
        }
        if( isset($fields['office_code']) && !empty($fields['office_code']) ){
            $criteria->add(ZipCode::OFFICE_CODE, $fields['office_code']);
        }
        if( isset($fields['zc_code']) && !empty($fields['zc_code']) ){
            $criteria->add(ZipCode::ZC_CODE, $fields['zc_code']);
        }
        if( isset($fields['settlement_type_code']) && !empty($fields['settlement_type_code']) ){
            $criteria->add(ZipCode::SETTLEMENT_TYPE_CODE, $fields['settlement_type_code']);
        }
        if( isset($fields['district_code']) && !empty($fields['district_code']) ){
            $criteria->add(ZipCode::DISTRICT_CODE, $fields['district_code']);
        }
        if( isset($fields['id_settlement_zip_code']) && !empty($fields['id_settlement_zip_code']) ){
            $criteria->add(ZipCode::ID_SETTLEMENT_ZIP_CODE, $fields['id_settlement_zip_code']);
        }
        if( isset($fields['zone']) && !empty($fields['zone']) ){
            $criteria->add(ZipCode::ZONE, $fields['zone']);
        }
        if( isset($fields['city_code']) && !empty($fields['city_code']) ){
            $criteria->add(ZipCode::CITY_CODE, $fields['city_code']);
        }

        $criteria->endPrefix();
    }


}