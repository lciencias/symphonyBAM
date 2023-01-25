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

use Query\Query;
use Application\Model\Catalog\FieldCatalog;
use Application\Model\Bean\Field;

use Application\Query\BaseQuery;

/**
 * Application\Query\FieldQuery
 *
 * @method \Application\Query\FieldQuery pk() pk(int $primaryKey)
 * @method \Application\Query\FieldQuery useMemoryCache()
 * @method \Application\Query\FieldQuery useFileCache()
 * @method \Application\Model\Collection\FieldCollection find()
 * @method \Application\Model\Bean\Field findOne()
 * @method \Application\Model\Bean\Field findOneOrElse() findOneOrElse(Field $alternative)
 * @method \Application\Model\Bean\Field findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Field findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Field findByPKOrElse() findByPKOrElse($pk, Field $alternative)
 * @method \Application\Model\Bean\Field findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\FieldQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\FieldQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\FieldQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\FieldQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\FieldQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\FieldQuery removeJoins()
 * @method \Application\Query\FieldQuery removeJoin() removeJoin($table)
 * @method \Application\Query\FieldQuery from() from($table, $alias = null)
 * @method \Application\Query\FieldQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\FieldQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\FieldQuery bind() bind($parameters)
 * @method \Application\Query\FieldQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\FieldQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\FieldQuery setLimit() setLimit($limit)
 * @method \Application\Query\FieldQuery setOffset() setOffset($offset)
 * @method \Application\Query\FieldQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\FieldQuery distinct()
 * @method \Application\Query\FieldQuery select()
 * @method \Application\Query\FieldQuery addColumns() addColumns($columns)
 * @method \Application\Query\FieldQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\FieldQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\FieldQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\FieldQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\FieldQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\FieldQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\FieldQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class FieldQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\FieldCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('FieldCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Field::TABLENAME, "Field");

        $defaultColumn = array("Field.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\FieldQuery
     */
    public function pk($value){
        $this->filter(array(
            Field::ID_FIELD => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Field::ID_FIELD, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\FieldQuery
     */
    public function filter($fields, $prefix = 'Field'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Field')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_field']) && !empty($fields['id_field']) ){
            $criteria->add(Field::ID_FIELD, $fields['id_field']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Field::NAME, $fields['name']);
        }
        if( isset($fields['reg_ex']) && !empty($fields['reg_ex']) ){
            $criteria->add(Field::REG_EX, $fields['reg_ex']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(Field::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Field::STATUS, $fields['status']);
        }
        if( isset($fields['sample']) && !empty($fields['sample']) ){
            $criteria->add(Field::SAMPLE, $fields['sample']);
        }

        $criteria->endPrefix();
    }
    /**
     * @return \Application\Query\FieldQuery
     */
    public function actives(){
    	return $this->filter(array(
    			Field::STATUS => Field::$Status['Active'],
    	));
    }

}