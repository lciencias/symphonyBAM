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
use Application\Model\Catalog\MenuItemCatalog;
use Application\Model\Bean\MenuItem;

use Application\Query\BaseQuery;

/**
 * Application\Query\MenuItemQuery
 *
 * @method \Application\Query\MenuItemQuery pk() pk(int $primaryKey)
 * @method \Application\Query\MenuItemQuery useMemoryCache()
 * @method \Application\Query\MenuItemQuery useFileCache()
 * @method \Application\Model\Collection\MenuItemCollection find()
 * @method \Application\Model\Bean\MenuItem findOne()
 * @method \Application\Model\Bean\MenuItem findOneOrElse() findOneOrElse(MenuItem $alternative)
 * @method \Application\Model\Bean\MenuItem findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\MenuItem findByPK() findByPK($pk)
 * @method \Application\Model\Bean\MenuItem findByPKOrElse() findByPKOrElse($pk, MenuItem $alternative)
 * @method \Application\Model\Bean\MenuItem findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\MenuItemQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\MenuItemQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\MenuItemQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\MenuItemQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\MenuItemQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\MenuItemQuery removeJoins()
 * @method \Application\Query\MenuItemQuery removeJoin() removeJoin($table)
 * @method \Application\Query\MenuItemQuery from() from($table, $alias = null)
 * @method \Application\Query\MenuItemQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\MenuItemQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\MenuItemQuery bind() bind($parameters)
 * @method \Application\Query\MenuItemQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\MenuItemQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\MenuItemQuery setLimit() setLimit($limit)
 * @method \Application\Query\MenuItemQuery setOffset() setOffset($offset)
 * @method \Application\Query\MenuItemQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\MenuItemQuery distinct()
 * @method \Application\Query\MenuItemQuery select()
 * @method \Application\Query\MenuItemQuery addColumns() addColumns($columns)
 * @method \Application\Query\MenuItemQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\MenuItemQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\MenuItemQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\MenuItemQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\MenuItemQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\MenuItemQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\MenuItemQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class MenuItemQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\MenuItemCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('MenuItemCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(MenuItem::TABLENAME, "MenuItem");

        $defaultColumn = array("MenuItem.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\MenuItemQuery
     */
    public function pk($value){
        $this->filter(array(
            MenuItem::ID_MENU_ITEM => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(MenuItem::ID_MENU_ITEM, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\MenuItemQuery
     */
    public function filter($fields, $prefix = 'MenuItem'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'MenuItem')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_menu_item']) && !empty($fields['id_menu_item']) ){
            $criteria->add(MenuItem::ID_MENU_ITEM, $fields['id_menu_item']);
        }
        if( isset($fields['id_parent']) && !empty($fields['id_parent']) ){
            $criteria->add(MenuItem::ID_PARENT, $fields['id_parent']);
        }
        if( isset($fields['id_action']) && !empty($fields['id_action']) ){
            $criteria->add(MenuItem::ID_ACTION, $fields['id_action']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(MenuItem::NAME, $fields['name']);
        }
        if( isset($fields['order']) && !empty($fields['order']) ){
            $criteria->add(MenuItem::ORDER, $fields['order']);
        }
        if( isset($fields['icon']) && !empty($fields['icon']) ){
            $criteria->add(MenuItem::ICON, $fields['icon']);
        }
        if( isset($fields['icon_size']) && !empty($fields['icon_size']) ){
            $criteria->add(MenuItem::ICON_SIZE, $fields['icon_size']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MenuItemQuery
     */
    public function innerJoinMenuItem($alias = 'MenuItem', $aliasForeignTable = 'MenuItem')
    {
        $this->innerJoinOn(\Application\Model\Bean\MenuItem::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_parent'), array($aliasForeignTable, 'id_menu_item'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\MenuItemQuery
     */
    public function innerJoinSecurityAction($alias = 'MenuItem', $aliasForeignTable = 'SecurityAction')
    {
        $this->innerJoinOn(\Application\Model\Bean\SecurityAction::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_action'), array($aliasForeignTable, 'id_action'));

        return $this;
    }


}