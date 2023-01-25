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
use Application\Model\Catalog\EmailCatalog;
use Application\Model\Bean\Email;

use Application\Query\BaseQuery;

/**
 * Application\Query\EmailQuery
 *
 * @method \Application\Query\EmailQuery pk() pk(int $primaryKey)
 * @method \Application\Query\EmailQuery useMemoryCache()
 * @method \Application\Query\EmailQuery useFileCache()
 * @method \Application\Model\Collection\EmailCollection find()
 * @method \Application\Model\Bean\Email findOne()
 * @method \Application\Model\Bean\Email findOneOrElse() findOneOrElse(Email $alternative)
 * @method \Application\Model\Bean\Email findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Email findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Email findByPKOrElse() findByPKOrElse($pk, Email $alternative)
 * @method \Application\Model\Bean\Email findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\EmailQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\EmailQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\EmailQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\EmailQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\EmailQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\EmailQuery removeJoins()
 * @method \Application\Query\EmailQuery removeJoin() removeJoin($table)
 * @method \Application\Query\EmailQuery from() from($table, $alias = null)
 * @method \Application\Query\EmailQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\EmailQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\EmailQuery bind() bind($parameters)
 * @method \Application\Query\EmailQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\EmailQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\EmailQuery setLimit() setLimit($limit)
 * @method \Application\Query\EmailQuery setOffset() setOffset($offset)
 * @method \Application\Query\EmailQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\EmailQuery distinct()
 * @method \Application\Query\EmailQuery select()
 * @method \Application\Query\EmailQuery addColumns() addColumns($columns)
 * @method \Application\Query\EmailQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\EmailQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\EmailQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\EmailQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\EmailQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\EmailQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\EmailQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class EmailQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\EmailCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('EmailCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Email::TABLENAME, "Email");

        $defaultColumn = array("Email.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\EmailQuery
     */
    public function pk($value){
        $this->filter(array(
            Email::ID_EMAIL => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Email::ID_EMAIL, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\EmailQuery
     */
    public function filter($fields, $prefix = 'Email'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Email')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_email']) && !empty($fields['id_email']) ){
            $criteria->add(Email::ID_EMAIL, $fields['id_email']);
        }
        if( isset($fields['email']) && !empty($fields['email']) ){
            $criteria->add(Email::EMAIL, $fields['email']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmailQuery
     */
    public function innerJoinPerson($alias = 'Email', $aliasForeignTable = 'Person')
    {
        $this->innerJoinOn('pcs_common_persons_emails', 'Email2Person')
            ->equalFields(array($alias, 'id_email'), array('Email2Person', 'id_email'));

        $this->innerJoinOn(\Application\Model\Bean\Person::TABLENAME, $aliasForeignTable)
            ->equalFields(array('Email2Person', 'id_person'), array($aliasForeignTable, 'id_person'));

        return $this;
    }


}