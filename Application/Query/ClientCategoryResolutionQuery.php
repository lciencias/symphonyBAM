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

use Application\Model\Bean\ClientCategory;

use Application\Model\Bean\Category;

use Query\Query;
use Application\Model\Catalog\ClientCategoryResolutionCatalog;
use Application\Model\Bean\ClientCategoryResolution;

use Application\Query\BaseQuery;

/**
 * Application\Query\ClientCategoryResolutionQuery
 *
 * @method \Application\Query\ClientCategoryResolutionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ClientCategoryResolutionQuery useMemoryCache()
 * @method \Application\Query\ClientCategoryResolutionQuery useFileCache()
 * @method \Application\Model\Collection\ClientCategoryResolutionCollection find()
 * @method \Application\Model\Bean\ClientCategoryResolution findOne()
 * @method \Application\Model\Bean\ClientCategoryResolution findOneOrElse() findOneOrElse(ClientCategoryResolution $alternative)
 * @method \Application\Model\Bean\ClientCategoryResolution findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\ClientCategoryResolution findByPK() findByPK($pk)
 * @method \Application\Model\Bean\ClientCategoryResolution findByPKOrElse() findByPKOrElse($pk, ClientCategoryResolution $alternative)
 * @method \Application\Model\Bean\ClientCategoryResolution findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ClientCategoryResolutionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery removeJoins()
 * @method \Application\Query\ClientCategoryResolutionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ClientCategoryResolutionQuery from() from($table, $alias = null)
 * @method \Application\Query\ClientCategoryResolutionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ClientCategoryResolutionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ClientCategoryResolutionQuery bind() bind($parameters)
 * @method \Application\Query\ClientCategoryResolutionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ClientCategoryResolutionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ClientCategoryResolutionQuery setLimit() setLimit($limit)
 * @method \Application\Query\ClientCategoryResolutionQuery setOffset() setOffset($offset)
 * @method \Application\Query\ClientCategoryResolutionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ClientCategoryResolutionQuery distinct()
 * @method \Application\Query\ClientCategoryResolutionQuery select()
 * @method \Application\Query\ClientCategoryResolutionQuery addColumns() addColumns($columns)
 * @method \Application\Query\ClientCategoryResolutionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ClientCategoryResolutionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ClientCategoryResolutionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ClientCategoryResolutionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ClientCategoryResolutionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ClientCategoryResolutionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ClientCategoryResolutionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ClientCategoryResolutionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ClientCategoryResolutionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ClientCategoryResolutionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(ClientCategoryResolution::TABLENAME, "ClientCategoryResolution");

        $defaultColumn = array("ClientCategoryResolution.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\ClientCategoryResolutionQuery
     */
    public function pk($value){
        $this->filter(array(
            ClientCategoryResolution::ID_CLIENT_CATEGORY_RESOLUTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(ClientCategoryResolution::ID_CLIENT_CATEGORY_RESOLUTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ClientCategoryResolutionQuery
     */
    public function filter($fields, $prefix = 'ClientCategoryResolution'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'ClientCategoryResolution')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_client_category_resolution']) && !empty($fields['id_client_category_resolution']) ){
            $criteria->add(ClientCategoryResolution::ID_CLIENT_CATEGORY_RESOLUTION, $fields['id_client_category_resolution']);
        }
        if( isset($fields['id_client_resolution']) && !empty($fields['id_client_resolution']) ){
            $criteria->add(ClientCategoryResolution::ID_CLIENT_RESOLUTION, $fields['id_client_resolution']);
        }
        if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(ClientCategoryResolution::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryResolutionQuery
     */
    public function innerJoinClientResolution($alias = 'ClientCategoryResolution', $aliasForeignTable = 'ClientResolution')
    {
        $this->innerJoinOn(\Application\Model\Bean\ClientResolution::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_resolution'), array($aliasForeignTable, 'id_resolution'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\ClientCategoryResolutionQuery
     */
    public function innerJoinClientCategory($alias = 'ClientCategoryResolution', $aliasForeignTable = 'ClientCategory')
    {
        $this->innerJoinOn(ClientCategory::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));

        return $this;
    }


}