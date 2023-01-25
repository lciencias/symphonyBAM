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
use Application\Model\Catalog\AddressCatalog;
use Application\Model\Bean\Address;

use Application\Query\BaseQuery;

/**
 * Application\Query\AddressQuery
 *
 * @method \Application\Query\AddressQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AddressQuery useMemoryCache()
 * @method \Application\Query\AddressQuery useFileCache()
 * @method \Application\Model\Collection\AddressCollection find()
 * @method \Application\Model\Bean\Address findOne()
 * @method \Application\Model\Bean\Address findOneOrElse() findOneOrElse(Address $alternative)
 * @method \Application\Model\Bean\Address findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Address findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Address findByPKOrElse() findByPKOrElse($pk, Address $alternative)
 * @method \Application\Model\Bean\Address findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AddressQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AddressQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AddressQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AddressQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AddressQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AddressQuery removeJoins()
 * @method \Application\Query\AddressQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AddressQuery from() from($table, $alias = null)
 * @method \Application\Query\AddressQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AddressQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AddressQuery bind() bind($parameters)
 * @method \Application\Query\AddressQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AddressQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AddressQuery setLimit() setLimit($limit)
 * @method \Application\Query\AddressQuery setOffset() setOffset($offset)
 * @method \Application\Query\AddressQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AddressQuery distinct()
 * @method \Application\Query\AddressQuery select()
 * @method \Application\Query\AddressQuery addColumns() addColumns($columns)
 * @method \Application\Query\AddressQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AddressQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AddressQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AddressQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AddressQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AddressQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AddressQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AddressQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\AddressCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AddressCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Address::TABLENAME, "Address");

        $defaultColumn = array("Address.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\AddressQuery
     */
    public function pk($value){
        $this->filter(array(
            Address::ID_ADDRESS => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Address::ID_ADDRESS, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AddressQuery
     */
    public function filter($fields, $prefix = 'Address'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Address')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_address']) && !empty($fields['id_address']) ){
            $criteria->add(Address::ID_ADDRESS, $fields['id_address']);
        }
        if( isset($fields['zip_code']) && !empty($fields['zip_code']) ){
            $criteria->add(Address::ZIP_CODE, $fields['zip_code']);
        }
        if( isset($fields['street']) && !empty($fields['street']) ){
            $criteria->add(Address::STREET, $fields['street']);
        }
        if( isset($fields['settlement']) && !empty($fields['settlement']) ){
            $criteria->add(Address::SETTLEMENT, $fields['settlement']);
        }
        if( isset($fields['district']) && !empty($fields['district']) ){
            $criteria->add(Address::DISTRICT, $fields['district']);
        }
        if( isset($fields['city']) && !empty($fields['city']) ){
            $criteria->add(Address::CITY, $fields['city']);
        }
        if( isset($fields['state']) && !empty($fields['state']) ){
            $criteria->add(Address::STATE, $fields['state']);
        }
        if( isset($fields['country']) && !empty($fields['country']) ){
            $criteria->add(Address::COUNTRY, $fields['country']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AddressQuery
     */
    public function innerJoinPerson($alias = 'Address', $aliasForeignTable = 'Person')
    {
        $this->innerJoinOn('pcs_common_persons_addresses', 'Address2Person')
            ->equalFields(array($alias, 'id_address'), array('Address2Person', 'id_address'));

        $this->innerJoinOn(\Application\Model\Bean\Person::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Address2Person', 'id_person'), array($aliasForeignTable, 'id_person'));

        return $this;
    }


}