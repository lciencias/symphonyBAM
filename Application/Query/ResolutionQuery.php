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
use Application\Model\Catalog\ResolutionCatalog;
use Application\Model\Bean\Resolution;

use Application\Query\BaseQuery;

/**
 * Application\Query\ResolutionQuery
 *
 * @method \Application\Query\ResolutionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ResolutionQuery useMemoryCache()
 * @method \Application\Query\ResolutionQuery useFileCache()
 * @method \Application\Model\Collection\ResolutionCollection find()
 * @method \Application\Model\Bean\Resolution findOne()
 * @method \Application\Model\Bean\Resolution findOneOrElse() findOneOrElse(Resolution $alternative)
 * @method \Application\Model\Bean\Resolution findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Resolution findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Resolution findByPKOrElse() findByPKOrElse($pk, Resolution $alternative)
 * @method \Application\Model\Bean\Resolution findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ResolutionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ResolutionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ResolutionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ResolutionQuery removeJoins()
 * @method \Application\Query\ResolutionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ResolutionQuery from() from($table, $alias = null)
 * @method \Application\Query\ResolutionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ResolutionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ResolutionQuery bind() bind($parameters)
 * @method \Application\Query\ResolutionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ResolutionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ResolutionQuery setLimit() setLimit($limit)
 * @method \Application\Query\ResolutionQuery setOffset() setOffset($offset)
 * @method \Application\Query\ResolutionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ResolutionQuery distinct()
 * @method \Application\Query\ResolutionQuery select()
 * @method \Application\Query\ResolutionQuery addColumns() addColumns($columns)
 * @method \Application\Query\ResolutionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ResolutionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ResolutionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ResolutionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ResolutionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ResolutionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ResolutionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ResolutionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ResolutionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ResolutionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Resolution::TABLENAME, "Resolution");

        $defaultColumn = array("Resolution.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ResolutionQuery
     */
    public function pk($value){
        $this->filter(array(
            Resolution::ID_RESOLUTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Resolution::ID_RESOLUTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ResolutionQuery
     */
    public function filter($fields, $prefix = 'Resolution'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Resolution')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_resolution']) && !empty($fields['id_resolution']) ){
            $criteria->add(Resolution::ID_RESOLUTION, $fields['id_resolution']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Resolution::NAME, $fields['name']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(Resolution::TYPE, $fields['type']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Resolution::STATUS, $fields['status']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ResolutionQuery
     */
    public function actives(){
        return $this->filter(array(
            Resolution::STATUS => Resolution::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\ResolutionQuery
     */
    public function inactives(){
        return $this->filter(array(
            Resolution::STATUS => Resolution::$Status['Inactive'],
        ));
    }


}