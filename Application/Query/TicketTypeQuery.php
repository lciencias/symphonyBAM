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
use Application\Model\Catalog\TicketTypeCatalog;
use Application\Model\Bean\TicketType;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketTypeQuery
 *
 * @method \Application\Query\TicketTypeQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketTypeQuery useMemoryCache()
 * @method \Application\Query\TicketTypeQuery useFileCache()
 * @method \Application\Model\Collection\TicketTypeCollection find()
 * @method \Application\Model\Bean\TicketType findOne()
 * @method \Application\Model\Bean\TicketType findOneOrElse() findOneOrElse(TicketType $alternative)
 * @method \Application\Model\Bean\TicketType findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketType findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketType findByPKOrElse() findByPKOrElse($pk, TicketType $alternative)
 * @method \Application\Model\Bean\TicketType findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketTypeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketTypeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketTypeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketTypeQuery removeJoins()
 * @method \Application\Query\TicketTypeQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketTypeQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketTypeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketTypeQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketTypeQuery bind() bind($parameters)
 * @method \Application\Query\TicketTypeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketTypeQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketTypeQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketTypeQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketTypeQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketTypeQuery distinct()
 * @method \Application\Query\TicketTypeQuery select()
 * @method \Application\Query\TicketTypeQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketTypeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketTypeQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketTypeQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketTypeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketTypeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketTypeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketTypeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketTypeQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketTypeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketTypeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketType::TABLENAME, "TicketType");

        $defaultColumn = array("TicketType.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketTypeQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketType::ID_TICKET_TYPE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketType::ID_TICKET_TYPE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketTypeQuery
     */
    public function filter($fields, $prefix = 'TicketType'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketType')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_type']) && !empty($fields['id_ticket_type']) ){
            $criteria->add(TicketType::ID_TICKET_TYPE, $fields['id_ticket_type']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(TicketType::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(TicketType::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\TicketTypeQuery
     */
    public function actives(){
        return $this->filter(array(
            TicketType::STATUS => TicketType::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\TicketTypeQuery
     */
    public function inactives(){
        return $this->filter(array(
            TicketType::STATUS => TicketType::$Status['Inactive'],
        ));
    }


}