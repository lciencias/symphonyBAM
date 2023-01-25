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
use Application\Model\Catalog\TranslateCatalog;
use Application\Model\Bean\Translate;

use Application\Query\BaseQuery;

/**
 * Application\Query\TranslateQuery
 *
 * @method \Application\Query\TranslateQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TranslateQuery useMemoryCache()
 * @method \Application\Query\TranslateQuery useFileCache()
 * @method \Application\Model\Collection\TranslateCollection find()
 * @method \Application\Model\Bean\Translate findOne()
 * @method \Application\Model\Bean\Translate findOneOrElse() findOneOrElse(Translate $alternative)
 * @method \Application\Model\Bean\Translate findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Translate findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Translate findByPKOrElse() findByPKOrElse($pk, Translate $alternative)
 * @method \Application\Model\Bean\Translate findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TranslateQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TranslateQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TranslateQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TranslateQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TranslateQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TranslateQuery removeJoins()
 * @method \Application\Query\TranslateQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TranslateQuery from() from($table, $alias = null)
 * @method \Application\Query\TranslateQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TranslateQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TranslateQuery bind() bind($parameters)
 * @method \Application\Query\TranslateQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TranslateQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TranslateQuery setLimit() setLimit($limit)
 * @method \Application\Query\TranslateQuery setOffset() setOffset($offset)
 * @method \Application\Query\TranslateQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TranslateQuery distinct()
 * @method \Application\Query\TranslateQuery select()
 * @method \Application\Query\TranslateQuery addColumns() addColumns($columns)
 * @method \Application\Query\TranslateQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TranslateQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TranslateQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TranslateQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TranslateQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TranslateQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TranslateQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TranslateQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TranslateCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TranslateCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Translate::TABLENAME, "Translate");

        $defaultColumn = array("Translate.*");
        $this->setDefaultColumn($defaultColumn);
        $this->useMemoryCache();
    }

    /**
     * @param mixed $value
     * @return Application\Query\TranslateQuery
     */
    public function pk($value){
        $this->filter(array(
            Translate::ID_TRANSLATE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Translate::ID_TRANSLATE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TranslateQuery
     */
    public function filter($fields, $prefix = 'Translate'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Translate')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_translate']) && !empty($fields['id_translate']) ){
            $criteria->add(Translate::ID_TRANSLATE, $fields['id_translate']);
        }
        if( isset($fields['string']) && !empty($fields['string']) ){
            $criteria->add(Translate::STRING, $fields['string']);
        }
        if( isset($fields['en']) && !empty($fields['en']) ){
            $criteria->add(Translate::EN, $fields['en']);
        }
        if( isset($fields['es']) && !empty($fields['es']) ){
            $criteria->add(Translate::ES, $fields['es']);
        }

        $criteria->endPrefix();
    }


}