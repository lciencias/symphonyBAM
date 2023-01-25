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
use Application\Model\Catalog\PersonCatalog;
use Application\Model\Bean\Person;

use Application\Query\BaseQuery;

/**
 * Application\Query\PersonQuery
 *
 * @method \Application\Query\PersonQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PersonQuery useMemoryCache()
 * @method \Application\Query\PersonQuery useFileCache()
 * @method \Application\Model\Collection\PersonCollection find()
 * @method \Application\Model\Bean\Person findOne()
 * @method \Application\Model\Bean\Person findOneOrElse() findOneOrElse(Person $alternative)
 * @method \Application\Model\Bean\Person findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Person findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Person findByPKOrElse() findByPKOrElse($pk, Person $alternative)
 * @method \Application\Model\Bean\Person findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PersonQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PersonQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PersonQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PersonQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PersonQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PersonQuery removeJoins()
 * @method \Application\Query\PersonQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PersonQuery from() from($table, $alias = null)
 * @method \Application\Query\PersonQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PersonQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PersonQuery bind() bind($parameters)
 * @method \Application\Query\PersonQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PersonQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PersonQuery setLimit() setLimit($limit)
 * @method \Application\Query\PersonQuery setOffset() setOffset($offset)
 * @method \Application\Query\PersonQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PersonQuery distinct()
 * @method \Application\Query\PersonQuery select()
 * @method \Application\Query\PersonQuery addColumns() addColumns($columns)
 * @method \Application\Query\PersonQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PersonQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PersonQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PersonQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PersonQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PersonQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PersonQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PersonQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PersonCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PersonCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Person::TABLENAME, "Person");

        $defaultColumn = array("Person.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\PersonQuery
     */
    public function pk($value){
        $this->filter(array(
            Person::ID_PERSON => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Person::ID_PERSON, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PersonQuery
     */
    public function filter($fields, $prefix = 'Person'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Person')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_person']) && !empty($fields['id_person']) ){
            $criteria->add(Person::ID_PERSON, $fields['id_person']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Person::NAME, $fields['name']);
        }
        if( isset($fields['last_name']) && !empty($fields['last_name']) ){
            $criteria->add(Person::LAST_NAME, $fields['last_name']);
        }
        if( isset($fields['middle_name']) && !empty($fields['middle_name']) ){
            $criteria->add(Person::MIDDLE_NAME, $fields['middle_name']);
        }
        if( isset($fields['curp']) && !empty($fields['curp']) ){
            $criteria->add(Person::CURP, $fields['curp']);
        }
        if( isset($fields['language']) && !empty($fields['language']) ){
            $criteria->add(Person::LANGUAGE, $fields['language']);
        }
        if( isset($fields['fullname']) && !empty($fields['fullname']) ){
            $terms = explode(' ', $fields['fullname']);
            $criteria->setAnd()->setOr();
            foreach ($terms as $term){
                $criteria->add(Person::NAME, $term, PersonQuery::LIKE);
                $criteria->add(Person::LAST_NAME, $term, PersonQuery::LIKE);
                $criteria->add(Person::MIDDLE_NAME, $term, PersonQuery::LIKE);
            }
            $criteria->end()->setAnd();
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PersonQuery
     */
    public function innerJoinAddress($alias = 'Person', $aliasForeignTable = 'Address')
    {
        $this->innerJoinOn('pcs_common_persons_addresses', 'Person2Address')
            ->equalFields(array($alias, 'id_person'), array('Person2Address', 'id_person'));

        $this->innerJoinOn(\Application\Model\Bean\Address::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Person2Address', 'id_address'), array($aliasForeignTable, 'id_address'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PersonQuery
     */
    public function innerJoinEmail($alias = 'Person', $aliasForeignTable = 'Email')
    {
        $this->innerJoinOn('pcs_common_persons_emails', 'Person2Email')
            ->equalFields(array($alias, 'id_person'), array('Person2Email', 'id_person'));

        $this->innerJoinOn(\Application\Model\Bean\Email::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Person2Email', 'id_email'), array($aliasForeignTable, 'id_email'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PersonQuery
     */
    public function innerJoinPhoneNumber($alias = 'Person', $aliasForeignTable = 'PhoneNumber')
    {
        $this->innerJoinOn('pcs_common_persons_phone_numbers', 'Person2PhoneNumber')
            ->equalFields(array($alias, 'id_person'), array('Person2PhoneNumber', 'id_person'));

        $this->innerJoinOn(\Application\Model\Bean\PhoneNumber::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Person2PhoneNumber', 'id_phone_number'), array($aliasForeignTable, 'id_phone_number'));

        return $this;
    }


}