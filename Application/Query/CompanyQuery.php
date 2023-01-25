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
use Application\Model\Catalog\CompanyCatalog;
use Application\Model\Bean\Company;

use Application\Query\BaseQuery;

/**
 * Application\Query\CompanyQuery
 *
 * @method \Application\Query\CompanyQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CompanyQuery useMemoryCache()
 * @method \Application\Query\CompanyQuery useFileCache()
 * @method \Application\Model\Collection\CompanyCollection find()
 * @method \Application\Model\Bean\Company findOne()
 * @method \Application\Model\Bean\Company findOneOrElse() findOneOrElse(Company $alternative)
 * @method \Application\Model\Bean\Company findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Company findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Company findByPKOrElse() findByPKOrElse($pk, Company $alternative)
 * @method \Application\Model\Bean\Company findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CompanyQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CompanyQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CompanyQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CompanyQuery removeJoins()
 * @method \Application\Query\CompanyQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CompanyQuery from() from($table, $alias = null)
 * @method \Application\Query\CompanyQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CompanyQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CompanyQuery bind() bind($parameters)
 * @method \Application\Query\CompanyQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CompanyQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CompanyQuery setLimit() setLimit($limit)
 * @method \Application\Query\CompanyQuery setOffset() setOffset($offset)
 * @method \Application\Query\CompanyQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CompanyQuery distinct()
 * @method \Application\Query\CompanyQuery select()
 * @method \Application\Query\CompanyQuery addColumns() addColumns($columns)
 * @method \Application\Query\CompanyQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CompanyQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CompanyQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CompanyQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CompanyQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CompanyQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CompanyQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CompanyQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CompanyCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CompanyCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Company::TABLENAME, "Company");

        $defaultColumn = array("Company.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\CompanyQuery
     */
    public function pk($value){
        $this->filter(array(
            Company::ID_COMPANY => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Company::ID_COMPANY, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CompanyQuery
     */
    public function filter($fields, $prefix = 'Company'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Company')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Company::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Company::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Company::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\CompanyQuery
     */
    public function actives(){
        return $this->filter(array(
            Company::STATUS => Company::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\CompanyQuery
     */
    public function inactives(){
        return $this->filter(array(
            Company::STATUS => Company::$Status['Inactive'],
        ));
    }


}