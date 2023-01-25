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
use Application\Model\Catalog\PhoneNumberCatalog;
use Application\Model\Bean\PhoneNumber;

use Application\Query\BaseQuery;

/**
 * Application\Query\PhoneNumberQuery
 *
 * @method \Application\Query\PhoneNumberQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PhoneNumberQuery useMemoryCache()
 * @method \Application\Query\PhoneNumberQuery useFileCache()
 * @method \Application\Model\Collection\PhoneNumberCollection find()
 * @method \Application\Model\Bean\PhoneNumber findOne()
 * @method \Application\Model\Bean\PhoneNumber findOneOrElse() findOneOrElse(PhoneNumber $alternative)
 * @method \Application\Model\Bean\PhoneNumber findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\PhoneNumber findByPK() findByPK($pk)
 * @method \Application\Model\Bean\PhoneNumber findByPKOrElse() findByPKOrElse($pk, PhoneNumber $alternative)
 * @method \Application\Model\Bean\PhoneNumber findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PhoneNumberQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PhoneNumberQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PhoneNumberQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PhoneNumberQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PhoneNumberQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PhoneNumberQuery removeJoins()
 * @method \Application\Query\PhoneNumberQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PhoneNumberQuery from() from($table, $alias = null)
 * @method \Application\Query\PhoneNumberQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PhoneNumberQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PhoneNumberQuery bind() bind($parameters)
 * @method \Application\Query\PhoneNumberQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PhoneNumberQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PhoneNumberQuery setLimit() setLimit($limit)
 * @method \Application\Query\PhoneNumberQuery setOffset() setOffset($offset)
 * @method \Application\Query\PhoneNumberQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PhoneNumberQuery distinct()
 * @method \Application\Query\PhoneNumberQuery select()
 * @method \Application\Query\PhoneNumberQuery addColumns() addColumns($columns)
 * @method \Application\Query\PhoneNumberQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PhoneNumberQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PhoneNumberQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PhoneNumberQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PhoneNumberQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PhoneNumberQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PhoneNumberQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PhoneNumberQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PhoneNumberCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PhoneNumberCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(PhoneNumber::TABLENAME, "PhoneNumber");

        $defaultColumn = array("PhoneNumber.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\PhoneNumberQuery
     */
    public function pk($value){
        $this->filter(array(
            PhoneNumber::ID_PHONE_NUMBER => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(PhoneNumber::ID_PHONE_NUMBER, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PhoneNumberQuery
     */
    public function filter($fields, $prefix = 'PhoneNumber'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'PhoneNumber')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_phone_number']) && !empty($fields['id_phone_number']) ){
            $criteria->add(PhoneNumber::ID_PHONE_NUMBER, $fields['id_phone_number']);
        }
        if( isset($fields['number']) && !empty($fields['number']) ){
            $criteria->add(PhoneNumber::NUMBER, $fields['number']);
        }
        if( isset($fields['area_code']) && !empty($fields['area_code']) ){
            $criteria->add(PhoneNumber::AREA_CODE, $fields['area_code']);
        }
        if( isset($fields['extension']) && !empty($fields['extension']) ){
            $criteria->add(PhoneNumber::EXTENSION, $fields['extension']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PhoneNumberQuery
     */
    public function innerJoinPerson($alias = 'PhoneNumber', $aliasForeignTable = 'Person')
    {
        $this->innerJoinOn('pcs_common_persons_phone_numbers', 'PhoneNumber2Person')
            ->equalFields(array($alias, 'id_phone_number'), array('PhoneNumber2Person', 'id_phone_number'));

        $this->innerJoinOn(\Application\Model\Bean\Person::TABLENAME, $aliasForeignTable)
            ->equalFields(array('PhoneNumber2Person', 'id_person'), array($aliasForeignTable, 'id_person'));

        return $this;
    }


}