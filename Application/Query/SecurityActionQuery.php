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
use Application\Model\Catalog\SecurityActionCatalog;
use Application\Model\Bean\SecurityAction;

use Application\Query\BaseQuery;

/**
 * Application\Query\SecurityActionQuery
 *
 * @method \Application\Query\SecurityActionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\SecurityActionQuery useMemoryCache()
 * @method \Application\Query\SecurityActionQuery useFileCache()
 * @method \Application\Model\Collection\SecurityActionCollection find()
 * @method \Application\Model\Bean\SecurityAction findOne()
 * @method \Application\Model\Bean\SecurityAction findOneOrElse() findOneOrElse(SecurityAction $alternative)
 * @method \Application\Model\Bean\SecurityAction findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\SecurityAction findByPK() findByPK($pk)
 * @method \Application\Model\Bean\SecurityAction findByPKOrElse() findByPKOrElse($pk, SecurityAction $alternative)
 * @method \Application\Model\Bean\SecurityAction findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\SecurityActionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\SecurityActionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityActionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityActionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\SecurityActionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\SecurityActionQuery removeJoins()
 * @method \Application\Query\SecurityActionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\SecurityActionQuery from() from($table, $alias = null)
 * @method \Application\Query\SecurityActionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\SecurityActionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\SecurityActionQuery bind() bind($parameters)
 * @method \Application\Query\SecurityActionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\SecurityActionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\SecurityActionQuery setLimit() setLimit($limit)
 * @method \Application\Query\SecurityActionQuery setOffset() setOffset($offset)
 * @method \Application\Query\SecurityActionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\SecurityActionQuery distinct()
 * @method \Application\Query\SecurityActionQuery select()
 * @method \Application\Query\SecurityActionQuery addColumns() addColumns($columns)
 * @method \Application\Query\SecurityActionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\SecurityActionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\SecurityActionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\SecurityActionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\SecurityActionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\SecurityActionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\SecurityActionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class SecurityActionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\SecurityActionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('SecurityActionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(SecurityAction::TABLENAME, "SecurityAction");

        $defaultColumn = array("SecurityAction.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\SecurityActionQuery
     */
    public function pk($value){
        $this->filter(array(
            SecurityAction::ID_ACTION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(SecurityAction::ID_ACTION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\SecurityActionQuery
     */
    public function filter($fields, $prefix = 'SecurityAction'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'SecurityAction')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_action']) && !empty($fields['id_action']) ){
            $criteria->add(SecurityAction::ID_ACTION, $fields['id_action']);
        }
        if( isset($fields['id_controller']) && !empty($fields['id_controller']) ){
            $criteria->add(SecurityAction::ID_CONTROLLER, $fields['id_controller']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(SecurityAction::NAME, $fields['name']);
        }
        if( isset($fields['tag_module']) && !empty($fields['tag_module']) ){
            $criteria->add(SecurityAction::TAG_MODULE, $fields['tag_module']);
        }
        if( isset($fields['tag_action']) && !empty($fields['tag_action']) ){
            $criteria->add(SecurityAction::TAG_ACTION, $fields['tag_action']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\SecurityActionQuery
     */
    public function innerJoinSecurityController($alias = 'SecurityAction', $aliasForeignTable = 'SecurityController')
    {
        $this->innerJoinOn(\Application\Model\Bean\SecurityController::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_controller'), array($aliasForeignTable, 'id_controller'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\SecurityActionQuery
     */
    public function innerJoinAccessRole($alias = 'SecurityAction', $aliasForeignTable = 'AccessRole')
    {
        $this->innerJoinOn('pcs_common_security_actions_access_roles', 'SecurityAction2AccessRole')
            ->equalFields(array($alias, 'id_action'), array('SecurityAction2AccessRole', 'id_security_action'));

        $this->innerJoinOn(\Application\Model\Bean\AccessRole::TABLENAME, $aliasForeignTable)
            ->equalFields(array('SecurityAction2AccessRole', 'id_access_role'), array($aliasForeignTable, 'id_access_role'));

        return $this;
    }


}