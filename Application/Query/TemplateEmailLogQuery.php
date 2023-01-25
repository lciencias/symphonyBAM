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
use Application\Model\Catalog\TemplateEmailLogCatalog;
use Application\Model\Bean\TemplateEmailLog;

use Application\Query\BaseQuery;

/**
 * Application\Query\TemplateEmailLogQuery
 *
 * @method \Application\Query\TemplateEmailLogQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TemplateEmailLogQuery useMemoryCache()
 * @method \Application\Query\TemplateEmailLogQuery useFileCache()
 * @method \Application\Model\Collection\TemplateEmailLogCollection find()
 * @method \Application\Model\Bean\TemplateEmailLog findOne()
 * @method \Application\Model\Bean\TemplateEmailLog findOneOrElse() findOneOrElse(TemplateEmailLog $alternative)
 * @method \Application\Model\Bean\TemplateEmailLog findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TemplateEmailLog findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TemplateEmailLog findByPKOrElse() findByPKOrElse($pk, TemplateEmailLog $alternative)
 * @method \Application\Model\Bean\TemplateEmailLog findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TemplateEmailLogQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery removeJoins()
 * @method \Application\Query\TemplateEmailLogQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TemplateEmailLogQuery from() from($table, $alias = null)
 * @method \Application\Query\TemplateEmailLogQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TemplateEmailLogQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TemplateEmailLogQuery bind() bind($parameters)
 * @method \Application\Query\TemplateEmailLogQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TemplateEmailLogQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TemplateEmailLogQuery setLimit() setLimit($limit)
 * @method \Application\Query\TemplateEmailLogQuery setOffset() setOffset($offset)
 * @method \Application\Query\TemplateEmailLogQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TemplateEmailLogQuery distinct()
 * @method \Application\Query\TemplateEmailLogQuery select()
 * @method \Application\Query\TemplateEmailLogQuery addColumns() addColumns($columns)
 * @method \Application\Query\TemplateEmailLogQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TemplateEmailLogQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TemplateEmailLogQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TemplateEmailLogQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TemplateEmailLogQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TemplateEmailLogQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TemplateEmailLogQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TemplateEmailLogQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TemplateEmailLogCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TemplateEmailLogCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TemplateEmailLog::TABLENAME, "TemplateEmailLog");

        $defaultColumn = array("TemplateEmailLog.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\TemplateEmailLogQuery
     */
    public function pk($value){
        $this->filter(array(
            TemplateEmailLog::ID_TEMPLATE_EMAIL_LOG => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TemplateEmailLog::ID_TEMPLATE_EMAIL_LOG, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TemplateEmailLogQuery
     */
    public function filter($fields, $prefix = 'TemplateEmailLog'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TemplateEmailLog')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_template_email_log']) && !empty($fields['id_template_email_log']) ){
            $criteria->add(TemplateEmailLog::ID_TEMPLATE_EMAIL_LOG, $fields['id_template_email_log']);
        }
        if( isset($fields['id_template_email']) && !empty($fields['id_template_email']) ){
            $criteria->add(TemplateEmailLog::ID_TEMPLATE_EMAIL, $fields['id_template_email']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(TemplateEmailLog::ID_USER, $fields['id_user']);
        }
        if( isset($fields['date_log']) && !empty($fields['date_log']) ){
            $criteria->add(TemplateEmailLog::DATE_LOG, $fields['date_log']);
        }
        if( isset($fields['event_type']) && !empty($fields['event_type']) ){
            $criteria->add(TemplateEmailLog::EVENT_TYPE, $fields['event_type']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(TemplateEmailLog::NOTE, $fields['note']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TemplateEmailLogQuery
     */
    public function innerJoinTemplateEmail($alias = 'TemplateEmailLog', $aliasForeignTable = 'TemplateEmail')
    {
        $this->innerJoinOn(\Application\Model\Bean\TemplateEmail::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_template_email'), array($aliasForeignTable, 'id_template_email'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TemplateEmailLogQuery
     */
    public function innerJoinUser($alias = 'TemplateEmailLog', $aliasForeignTable = 'User')
    {
        $this->innerJoinOn(\Application\Model\Bean\User::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user'), array($aliasForeignTable, 'id_user'));

        return $this;
    }


}