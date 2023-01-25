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
use Application\Model\Catalog\SessionCatalog;
use Application\Model\Bean\Session;

use Application\Query\BaseQuery;

/**
 * Application\Query\SessionQuery
 *
 * @method \Application\Query\SessionQuery pk() pk(int $primaryKey)
 * @method \Application\Query\SessionQuery useMemoryCache()
 * @method \Application\Query\SessionQuery useFileCache()
 * @method \Application\Model\Collection\SessionCollection find()
 * @method \Application\Model\Bean\Session findOne()
 * @method \Application\Model\Bean\Session findOneOrElse() findOneOrElse(Session $alternative)
 * @method \Application\Model\Bean\Session findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Session findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Session findByPKOrElse() findByPKOrElse($pk, Session $alternative)
 * @method \Application\Model\Bean\Session findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\SessionQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\SessionQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\SessionQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\SessionQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\SessionQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\SessionQuery removeJoins()
 * @method \Application\Query\SessionQuery removeJoin() removeJoin($table)
 * @method \Application\Query\SessionQuery from() from($table, $alias = null)
 * @method \Application\Query\SessionQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\SessionQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\SessionQuery bind() bind($parameters)
 * @method \Application\Query\SessionQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\SessionQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\SessionQuery setLimit() setLimit($limit)
 * @method \Application\Query\SessionQuery setOffset() setOffset($offset)
 * @method \Application\Query\SessionQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\SessionQuery distinct()
 * @method \Application\Query\SessionQuery select()
 * @method \Application\Query\SessionQuery addColumns() addColumns($columns)
 * @method \Application\Query\SessionQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\SessionQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\SessionQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\SessionQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\SessionQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\SessionQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\SessionQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class SessionQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\SessionCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('SessionCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Session::TABLENAME, "Session");

        $defaultColumn = array("Session.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\SessionQuery
     */
    public function pk($value){
        $this->filter(array(
            Session::ID_SESSION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Session::ID_SESSION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\SessionQuery
     */
    public function filter($fields, $prefix = 'Session'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Session')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_session']) && !empty($fields['id_session']) ){
            $criteria->add(Session::ID_SESSION, $fields['id_session']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(Session::ID_USER, $fields['id_user']);
        }
        if( isset($fields['hash']) && !empty($fields['hash']) ){
            $criteria->add(Session::HASH, $fields['hash']);
        }
        if( isset($fields['last_request']) && !empty($fields['last_request']) ){
            $criteria->add(Session::LAST_REQUEST, $fields['last_request']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\SessionQuery
     */
    public function innerJoinUser($alias = 'Session', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}