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
use Application\Model\Catalog\PositionCatalog;
use Application\Model\Bean\Position;

use Application\Query\BaseQuery;

/**
 * Application\Query\PositionQuery
 *
 * @method \Application\Query\PositionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\PositionQuery useMemoryCache()
 * @method \Application\Query\PositionQuery useFileCache()
 * @method \Application\Model\Collection\PositionCollection find()
 * @method \Application\Model\Bean\Position findOne()
 * @method \Application\Model\Bean\Position findOneOrElse() findOneOrElse(Position $alternative)
 * @method \Application\Model\Bean\Position findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Position findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Position findByPKOrElse() findByPKOrElse($pk, Position $alternative)
 * @method \Application\Model\Bean\Position findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\PositionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\PositionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\PositionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\PositionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\PositionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\PositionQuery removeJoins()
 * @method \Application\Query\PositionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\PositionQuery from() from($table, $alias = null)
 * @method \Application\Query\PositionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\PositionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\PositionQuery bind() bind($parameters)
 * @method \Application\Query\PositionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\PositionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\PositionQuery setLimit() setLimit($limit)
 * @method \Application\Query\PositionQuery setOffset() setOffset($offset)
 * @method \Application\Query\PositionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\PositionQuery distinct()
 * @method \Application\Query\PositionQuery select()
 * @method \Application\Query\PositionQuery addColumns() addColumns($columns)
 * @method \Application\Query\PositionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\PositionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\PositionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\PositionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\PositionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\PositionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\PositionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class PositionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\PositionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('PositionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Position::TABLENAME, "Position");

        $defaultColumn = array("Position.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\PositionQuery
     */
    public function pk($value){
        $this->filter(array(
            Position::ID_POSITION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Position::ID_POSITION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\PositionQuery
     */
    public function filter($fields, $prefix = 'Position'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Position')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_position']) && !empty($fields['id_position']) ){
            $criteria->add(Position::ID_POSITION, $fields['id_position']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Position::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Position::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Position::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\PositionQuery
     */
    public function actives(){
        return $this->filter(array(
            Position::STATUS => Position::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\PositionQuery
     */
    public function inactives(){
        return $this->filter(array(
            Position::STATUS => Position::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\PositionQuery
     */
    public function innerJoinCompany($alias = 'Position', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }


}