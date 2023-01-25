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

use Application\Model\Factory\OptionFactory;

use Application\Storage\StorageFactory;

use Query\Query;
use Application\Model\Catalog\OptionCatalog;
use Application\Model\Bean\Option;
use Application\Query\BaseQuery;

/**
 * Application\Query\OptionQuery
 *
 * @method \Application\Query\OptionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\OptionQuery useMemoryCache()
 * @method \Application\Query\OptionQuery useFileCache()
 * @method \Application\Model\Collection\OptionCollection find()
 * @method \Application\Model\Bean\Option findOne()
 * @method \Application\Model\Bean\Option findOneOrElse() findOneOrElse(Option $alternative)
 * @method \Application\Model\Bean\Option findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Option findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Option findByPKOrElse() findByPKOrElse($pk, Option $alternative)
 * @method \Application\Model\Bean\Option findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\OptionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\OptionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\OptionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\OptionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\OptionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\OptionQuery removeJoins()
 * @method \Application\Query\OptionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\OptionQuery from() from($table, $alias = null)
 * @method \Application\Query\OptionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\OptionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\OptionQuery bind() bind($parameters)
 * @method \Application\Query\OptionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\OptionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\OptionQuery setLimit() setLimit($limit)
 * @method \Application\Query\OptionQuery setOffset() setOffset($offset)
 * @method \Application\Query\OptionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\OptionQuery distinct()
 * @method \Application\Query\OptionQuery select()
 * @method \Application\Query\OptionQuery addColumns() addColumns($columns)
 * @method \Application\Query\OptionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\OptionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\OptionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\OptionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\OptionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\OptionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\OptionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class OptionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\OptionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('OptionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Option::TABLENAME, "Option");

        $defaultColumn = array("Option.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\OptionQuery
     */
    public function pk($value){
        $this->filter(array(
            Option::ID_OPTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Option::ID_OPTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\OptionQuery
     */
    public function filter($fields, $prefix = 'Option'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Option')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_option']) && !empty($fields['id_option']) ){
            $criteria->add(Option::ID_OPTION, $fields['id_option']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Option::NAME, $fields['name']);
        }
        if( isset($fields['value']) && !empty($fields['value']) ){
            $criteria->add(Option::VALUE, $fields['value']);
        }
        if( isset($fields['type']) && !empty($fields['type']) ){
            $criteria->add(Option::TYPE, $fields['type']);
        }
        if( isset($fields['regexp']) && !empty($fields['regexp']) ){
            $criteria->add(Option::REGEXP, $fields['regexp']);
        }
        if( isset($fields['detail']) && !empty($fields['detail']) ){
            $criteria->add(Option::DETAIL, $fields['detail']);
        }
        if( isset($fields['options']) && !empty($fields['options']) ){
            $criteria->add(Option::OPTIONS, $fields['options']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return int
     */
    public function fetchSessionExpiration(){
       return (int) $this->findByPKOrElse(Option::SESSION_EXPIRATION,
            OptionFactory::createFromArray(array('value' => 5)))
            ->getValue();
    }


}