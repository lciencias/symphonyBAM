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
use Application\Model\Catalog\MexicoZipCodeCatalog;
use Application\Model\Bean\MexicoZipCode;

use Application\Query\BaseQuery;

/**
 * Application\Query\MexicoZipCodeQuery
 *
 * @method \Application\Query\MexicoZipCodeQuery pk() pk(int $primaryKey)
 * @method \Application\Query\MexicoZipCodeQuery useMemoryCache()
 * @method \Application\Query\MexicoZipCodeQuery useFileCache()
 * @method \Application\Model\Collection\MexicoZipCodeCollection find()
 * @method \Application\Model\Bean\MexicoZipCode findOne()
 * @method \Application\Model\Bean\MexicoZipCode findOneOrElse() findOneOrElse(MexicoZipCode $alternative)
 * @method \Application\Model\Bean\MexicoZipCode findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\MexicoZipCode findByPK() findByPK($pk)
 * @method \Application\Model\Bean\MexicoZipCode findByPKOrElse() findByPKOrElse($pk, MexicoZipCode $alternative)
 * @method \Application\Model\Bean\MexicoZipCode findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\MexicoZipCodeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery removeJoins()
 * @method \Application\Query\MexicoZipCodeQuery removeJoin() removeJoin($table)
 * @method \Application\Query\MexicoZipCodeQuery from() from($table, $alias = null)
 * @method \Application\Query\MexicoZipCodeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\MexicoZipCodeQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\MexicoZipCodeQuery bind() bind($parameters)
 * @method \Application\Query\MexicoZipCodeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\MexicoZipCodeQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\MexicoZipCodeQuery setLimit() setLimit($limit)
 * @method \Application\Query\MexicoZipCodeQuery setOffset() setOffset($offset)
 * @method \Application\Query\MexicoZipCodeQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\MexicoZipCodeQuery distinct()
 * @method \Application\Query\MexicoZipCodeQuery select()
 * @method \Application\Query\MexicoZipCodeQuery addColumns() addColumns($columns)
 * @method \Application\Query\MexicoZipCodeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\MexicoZipCodeQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\MexicoZipCodeQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\MexicoZipCodeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\MexicoZipCodeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\MexicoZipCodeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\MexicoZipCodeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class MexicoZipCodeQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\MexicoZipCodeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('MexicoZipCodeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(MexicoZipCode::TABLENAME, "MexicoZipCode");

        $defaultColumn = array("MexicoZipCode.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\MexicoZipCodeQuery
     */
    public function pk($value){
        $this->filter(array(
            MexicoZipCode::ID_ZIP_CODE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(MexicoZipCode::ID_ZIP_CODE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\MexicoZipCodeQuery
     */
    public function filter($fields, $prefix = 'MexicoZipCode'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'MexicoZipCode')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_zip_code']) && !empty($fields['id_zip_code']) ){
            $criteria->add(MexicoZipCode::ID_ZIP_CODE, $fields['id_zip_code']);
        }
        if( isset($fields['zip_code']) && !empty($fields['zip_code']) ){
            $criteria->add(MexicoZipCode::ZIP_CODE, $fields['zip_code']);
        }
        if( isset($fields['settlement']) && !empty($fields['settlement']) ){
            $criteria->add(MexicoZipCode::SETTLEMENT, $fields['settlement']);
        }
        if( isset($fields['settlement_type']) && !empty($fields['settlement_type']) ){
            $criteria->add(MexicoZipCode::SETTLEMENT_TYPE, $fields['settlement_type']);
        }
        if( isset($fields['district']) && !empty($fields['district']) ){
            $criteria->add(MexicoZipCode::DISTRICT, $fields['district']);
        }
        if( isset($fields['state']) && !empty($fields['state']) ){
            $criteria->add(MexicoZipCode::STATE, $fields['state']);
        }
        if( isset($fields['city']) && !empty($fields['city']) ){
            $criteria->add(MexicoZipCode::CITY, $fields['city']);
        }
        if( isset($fields['d_cp']) && !empty($fields['d_cp']) ){
            $criteria->add(MexicoZipCode::D_CP, $fields['d_cp']);
        }
        if( isset($fields['id_mexico_state']) && !empty($fields['id_mexico_state']) ){
            $criteria->add(MexicoZipCode::ID_MEXICO_STATE, $fields['id_mexico_state']);
        }
        if( isset($fields['office_code']) && !empty($fields['office_code']) ){
            $criteria->add(MexicoZipCode::OFFICE_CODE, $fields['office_code']);
        }
        if( isset($fields['zc_code']) && !empty($fields['zc_code']) ){
            $criteria->add(MexicoZipCode::ZC_CODE, $fields['zc_code']);
        }
        if( isset($fields['settlement_type_code']) && !empty($fields['settlement_type_code']) ){
            $criteria->add(MexicoZipCode::SETTLEMENT_TYPE_CODE, $fields['settlement_type_code']);
        }
        if( isset($fields['district_code']) && !empty($fields['district_code']) ){
            $criteria->add(MexicoZipCode::DISTRICT_CODE, $fields['district_code']);
        }
        if( isset($fields['id_settlement_zip_code']) && !empty($fields['id_settlement_zip_code']) ){
            $criteria->add(MexicoZipCode::ID_SETTLEMENT_ZIP_CODE, $fields['id_settlement_zip_code']);
        }
        if( isset($fields['zone']) && !empty($fields['zone']) ){
            $criteria->add(MexicoZipCode::ZONE, $fields['zone']);
        }
        if( isset($fields['city_code']) && !empty($fields['city_code']) ){
            $criteria->add(MexicoZipCode::CITY_CODE, $fields['city_code']);
        }

        $criteria->endPrefix();
    }


}