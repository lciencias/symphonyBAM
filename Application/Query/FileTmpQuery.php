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
use Application\Model\Catalog\FileTmpCatalog;
use Application\Model\Bean\FileTmp;

use Application\Query\BaseQuery;

/**
 * Application\Query\FileTmpQuery
 *
 * @method \Application\Query\FileTmpQuery pk() pk(int $primaryKey)
 * @method \Application\Query\FileTmpQuery useMemoryCache()
 * @method \Application\Query\FileTmpQuery useFileCache()
 * @method \Application\Model\Collection\FileTmpCollection find()
 * @method \Application\Model\Bean\FileTmp findOne()
 * @method \Application\Model\Bean\FileTmp findOneOrElse() findOneOrElse(File $alternative)
 * @method \Application\Model\Bean\FileTmp findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\FileTmp findByPK() findByPK($pk)
 * @method \Application\Model\Bean\FileTmp findByPKOrElse() findByPKOrElse($pk, File $alternative)
 * @method \Application\Model\Bean\FileTmp findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\FileTmpQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\FileTmpQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\FileTmpQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\FileTmpQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\FileTmpQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\FileTmpQuery removeJoins()
 * @method \Application\Query\FileTmpQuery removeJoin() removeJoin($table)
 * @method \Application\Query\FileTmpQuery from() from($table, $alias = null)
 * @method \Application\Query\FileTmpQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\FileTmpQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\FileTmpQuery bind() bind($parameters)
 * @method \Application\Query\FileTmpQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\FileTmpQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\FileTmpQuery setLimit() setLimit($limit)
 * @method \Application\Query\FileTmpQuery setOffset() setOffset($offset)
 * @method \Application\Query\FileTmpQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\FileTmpQuery distinct()
 * @method \Application\Query\FileTmpQuery select()
 * @method \Application\Query\FileTmpQuery addColumns() addColumns($columns)
 * @method \Application\Query\FileTmpQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\FileTmpQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\FileTmpQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\FileTmpQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\FileTmpQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\FileTmpQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\FileTmpQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class FileTmpQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\FileTmpCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('FileTmpCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(FileTmp::TABLENAME, "FileTmp");

        $defaultColumn = array("FileTmp.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\FileTmpQuery
     */
    public function pk($value){
        $this->filter(array(
            FileTmp::ID_FILE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(FileTmp::ID_FILE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\FileTmpQuery
     */
    public function filter($fields, $prefix = 'FileTmp'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'FileTmp')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
            $criteria->add(FileTmp::ID_FILE, $fields['id_file']);
        }
        if( isset($fields['uri']) && !empty($fields['uri']) ){
            $criteria->add(FileTmp::URI, $fields['uri']);
        }
        if( isset($fields['original_name']) && !empty($fields['original_name']) ){
            $criteria->add(FileTmp::ORIGINAL_NAME, $fields['original_name']);            
        }
        if( isset($fields['id_transaction']) && !empty($fields['id_transaction']) ){
            $criteria->add(FileTmp::ID_TRANSACTION, $fields['id_transaction']);            
        }
        if( isset($fields['amount_deposit']) && !empty($fields['amount_deposit']) ){
        	$criteria->add(FileTmp::AMOUNT_DEPOSIT, $fields['amount_deposit']);
        }
        if( isset($fields['date_deposit']) && !empty($fields['date_deposit']) ){
        	$criteria->add(FileTmp::DATE_DEPOSIT, $fields['date_deposit']);
        }
        if( isset($fields['type_deposit']) && !empty($fields['type_deposit']) ){
        	$criteria->add(FileTmp::TYPE_DEPOSIT, $fields['type_deposit']);
        }
        if( isset($fields['id_session']) && !empty($fields['id_session']) ){
        	$criteria->add(FileTmp::ID_SESSION, $fields['id_session']);
        }
        $criteria->endPrefix();
    }


}