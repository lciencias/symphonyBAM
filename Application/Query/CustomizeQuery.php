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
use Application\Model\Catalog\CustomizeCatalog;
use Application\Model\Bean\Customize;

use Application\Query\BaseQuery;

/**
 * Application\Query\CustomizeQuery
 *
 * @method \Application\Query\CustomizeQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CustomizeQuery useMemoryCache()
 * @method \Application\Query\CustomizeQuery useFileCache()
 * @method \Application\Model\Collection\CustomizeCollection find()
 * @method \Application\Model\Bean\Customize findOne()
 * @method \Application\Model\Bean\Customize findOneOrElse() findOneOrElse(Customize $alternative)
 * @method \Application\Model\Bean\Customize findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Customize findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Customize findByPKOrElse() findByPKOrElse($pk, Customize $alternative)
 * @method \Application\Model\Bean\Customize findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CustomizeQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CustomizeQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CustomizeQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CustomizeQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CustomizeQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CustomizeQuery removeJoins()
 * @method \Application\Query\CustomizeQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CustomizeQuery from() from($table, $alias = null)
 * @method \Application\Query\CustomizeQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CustomizeQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CustomizeQuery bind() bind($parameters)
 * @method \Application\Query\CustomizeQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CustomizeQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CustomizeQuery setLimit() setLimit($limit)
 * @method \Application\Query\CustomizeQuery setOffset() setOffset($offset)
 * @method \Application\Query\CustomizeQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CustomizeQuery distinct()
 * @method \Application\Query\CustomizeQuery select()
 * @method \Application\Query\CustomizeQuery addColumns() addColumns($columns)
 * @method \Application\Query\CustomizeQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CustomizeQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CustomizeQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CustomizeQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CustomizeQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CustomizeQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CustomizeQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CustomizeQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\CustomizeCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CustomizeCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Customize::TABLENAME, "Customize");

        $defaultColumn = array("Customize.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\CustomizeQuery
     */
    public function pk($value){
        $this->filter(array(
            Customize::ID_PCS_COMMON_CUSTOMIZE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Customize::ID_PCS_COMMON_CUSTOMIZE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\CustomizeQuery
     */
    public function filter($fields, $prefix = 'Customize'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Customize')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_pcs_common_customize']) && !empty($fields['id_pcs_common_customize']) ){
            $criteria->add(Customize::ID_PCS_COMMON_CUSTOMIZE, $fields['id_pcs_common_customize']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(Customize::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['logo']) && !empty($fields['logo']) ){
            $criteria->add(Customize::LOGO, $fields['logo']);
        }
        if( isset($fields['background_color']) && !empty($fields['background_color']) ){
            $criteria->add(Customize::BACKGROUND_COLOR, $fields['background_color']);
        }
        if( isset($fields['forward_color']) && !empty($fields['forward_color']) ){
            $criteria->add(Customize::FORWARD_COLOR, $fields['forward_color']);
        }
        if( isset($fields['font_size']) && !empty($fields['font_size']) ){
            $criteria->add(Customize::FONT_SIZE, $fields['font_size']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CustomizeQuery
     */
    public function innerJoinCompany($alias = 'Customize', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }


}