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
use Application\Model\Catalog\NotificationCatalog;
use Application\Model\Bean\Notification;

use Application\Query\BaseQuery;

/**
 * Application\Query\NotificationQuery
 *
 * @method \Application\Query\NotificationQuery pk() pk(int $primaryKey)
 * @method \Application\Query\NotificationQuery useMemoryCache()
 * @method \Application\Query\NotificationQuery useFileCache()
 * @method \Application\Model\Collection\NotificationCollection find()
 * @method \Application\Model\Bean\Notification findOne()
 * @method \Application\Model\Bean\Notification findOneOrElse() findOneOrElse(Notification $alternative)
 * @method \Application\Model\Bean\Notification findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Notification findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Notification findByPKOrElse() findByPKOrElse($pk, Notification $alternative)
 * @method \Application\Model\Bean\Notification findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\NotificationQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\NotificationQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\NotificationQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\NotificationQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\NotificationQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\NotificationQuery removeJoins()
 * @method \Application\Query\NotificationQuery removeJoin() removeJoin($table)
 * @method \Application\Query\NotificationQuery from() from($table, $alias = null)
 * @method \Application\Query\NotificationQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\NotificationQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\NotificationQuery bind() bind($parameters)
 * @method \Application\Query\NotificationQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\NotificationQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\NotificationQuery setLimit() setLimit($limit)
 * @method \Application\Query\NotificationQuery setOffset() setOffset($offset)
 * @method \Application\Query\NotificationQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\NotificationQuery distinct()
 * @method \Application\Query\NotificationQuery select()
 * @method \Application\Query\NotificationQuery addColumns() addColumns($columns)
 * @method \Application\Query\NotificationQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\NotificationQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\NotificationQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\NotificationQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\NotificationQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\NotificationQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\NotificationQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class NotificationQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\NotificationCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('NotificationCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Notification::TABLENAME, "Notification");

        $defaultColumn = array("Notification.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\NotificationQuery
     */
    public function pk($value){
        $this->filter(array(
            Notification::ID_NOTIFICATION => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Notification::ID_NOTIFICATION, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\NotificationQuery
     */
    public function filter($fields, $prefix = 'Notification'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Notification')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_notification']) && !empty($fields['id_notification']) ){
            $criteria->add(Notification::ID_NOTIFICATION, $fields['id_notification']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Notification::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_template_email']) && !empty($fields['id_template_email']) ){
            $criteria->add(Notification::ID_TEMPLATE_EMAIL, $fields['id_template_email']);
        }
        if( isset($fields['to']) && !empty($fields['to']) ){
            $criteria->add(Notification::TO, $fields['to']);
        }
        if( isset($fields['dispatched']) && !empty($fields['dispatched']) ){
            $criteria->add(Notification::DISPATCHED, $fields['dispatched']);
        }
        if( isset($fields['created']) && !empty($fields['created']) ){
            $criteria->add(Notification::CREATED, $fields['created']);
        }
        if( isset($fields['cc']) && !empty($fields['cc']) ){
            $criteria->add(Notification::CC, $fields['cc']);
        }
        if( isset($fields['bcc']) && !empty($fields['bcc']) ){
            $criteria->add(Notification::BCC, $fields['bcc']);
        }
        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
        	$criteria->add(Notification::ID_FILE, $fields['id_file']);
        }
        
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\NotificationQuery
     */
    public function innerJoinTemplateEmail($alias = 'Notification', $aliasForeignTable = 'TemplateEmail')
    {
        $this->innerJoinOn(\Application\Model\Bean\TemplateEmail::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_template_email'), array($aliasForeignTable, 'id_template_email'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\NotificationQuery
     */
    public function innerJoinBaseTicket($alias = 'Notification', $aliasForeignTable = 'BaseTicket')
    {
        $this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }


}