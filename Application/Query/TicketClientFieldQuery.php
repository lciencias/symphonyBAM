<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\Field;

use Query\Query;
use Application\Model\Catalog\TicketClientFieldCatalog;
use Application\Model\Bean\TicketClientField;

use Application\Query\BaseQuery;

/**
 * Application\Query\TicketClientFieldQuery
 *
 * @method \Application\Query\TicketClientFieldQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TicketClientFieldQuery useMemoryCache()
 * @method \Application\Query\TicketClientFieldQuery useFileCache()
 * @method \Application\Model\Collection\TicketClientFieldCollection find()
 * @method \Application\Model\Bean\TicketClientField findOne()
 * @method \Application\Model\Bean\TicketClientField findOneOrElse() findOneOrElse(TicketClientField $alternative)
 * @method \Application\Model\Bean\TicketClientField findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TicketClientField findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TicketClientField findByPKOrElse() findByPKOrElse($pk, TicketClientField $alternative)
 * @method \Application\Model\Bean\TicketClientField findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TicketClientFieldQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery removeJoins()
 * @method \Application\Query\TicketClientFieldQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TicketClientFieldQuery from() from($table, $alias = null)
 * @method \Application\Query\TicketClientFieldQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TicketClientFieldQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TicketClientFieldQuery bind() bind($parameters)
 * @method \Application\Query\TicketClientFieldQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TicketClientFieldQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TicketClientFieldQuery setLimit() setLimit($limit)
 * @method \Application\Query\TicketClientFieldQuery setOffset() setOffset($offset)
 * @method \Application\Query\TicketClientFieldQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TicketClientFieldQuery distinct()
 * @method \Application\Query\TicketClientFieldQuery select()
 * @method \Application\Query\TicketClientFieldQuery addColumns() addColumns($columns)
 * @method \Application\Query\TicketClientFieldQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TicketClientFieldQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TicketClientFieldQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TicketClientFieldQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TicketClientFieldQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TicketClientFieldQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TicketClientFieldQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TicketClientFieldQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TicketClientFieldCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TicketClientFieldCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TicketClientField::TABLENAME, "TicketClientField");

        $defaultColumn = array("TicketClientField.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TicketClientFieldQuery
     */
    public function pk($value){
        $this->filter(array(
            TicketClientField::ID_TICKET_CLIENT_FIELD => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TicketClientField::ID_TICKET_CLIENT_FIELD, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TicketClientFieldQuery
     */
    public function filter($fields, $prefix = 'TicketClientField'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TicketClientField')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_ticket_client_field']) && !empty($fields['id_ticket_client_field']) ){
            $criteria->add(TicketClientField::ID_TICKET_CLIENT_FIELD, $fields['id_ticket_client_field']);
        }
        if( isset($fields['id_ticket_client']) && !empty($fields['id_ticket_client']) ){
            $criteria->add(TicketClientField::ID_TICKET_CLIENT, $fields['id_ticket_client']);
        }
		if( isset($fields['id_field']) && !empty($fields['id_field']) ){
            $criteria->add(TicketClientField::ID_FIELD, $fields['id_field']);
        }
		if( isset($fields['value']) && !empty($fields['value']) ){
            $criteria->add(TicketClientField::VALUE, $fields['value']);
        }
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientFieldQuery
     */
    public function innerJoinField($alias = 'TicketClientField', $aliasForeignTable = 'Field')
    {
        $this->innerJoinOn(Field::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_field'), array($aliasForeignTable, 'id_field'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TicketClientFieldQuery
     */
    public function innerJoinTicketClient($alias = 'TicketClientField', $aliasForeignTable = 'TicketClient')
    {
        $this->innerJoinOn(TicketClient::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_ticket_client'), array($aliasForeignTable, 'id_ticket_client'));

        return $this;
    }


}