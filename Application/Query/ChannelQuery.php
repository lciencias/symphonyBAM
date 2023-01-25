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

use Application\Storage\StorageFactory;

use Query\Query;
use Application\Model\Catalog\ChannelCatalog;
use Application\Model\Bean\Channel;

use Application\Query\BaseQuery;

/**
 * Application\Query\ChannelQuery
 *
 * @method \Application\Query\ChannelQuery pk() pk(int $primaryKey)
 * @method \Application\Query\ChannelQuery useMemoryCache()
 * @method \Application\Query\ChannelQuery useFileCache()
 * @method \Application\Model\Collection\ChannelCollection find()
 * @method \Application\Model\Bean\Channel findOne()
 * @method \Application\Model\Bean\Channel findOneOrElse() findOneOrElse(Channel $alternative)
 * @method \Application\Model\Bean\Channel findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Channel findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Channel findByPKOrElse() findByPKOrElse($pk, Channel $alternative)
 * @method \Application\Model\Bean\Channel findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\ChannelQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\ChannelQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\ChannelQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\ChannelQuery removeJoins()
 * @method \Application\Query\ChannelQuery removeJoin() removeJoin($table)
 * @method \Application\Query\ChannelQuery from() from($table, $alias = null)
 * @method \Application\Query\ChannelQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\ChannelQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\ChannelQuery bind() bind($parameters)
 * @method \Application\Query\ChannelQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\ChannelQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\ChannelQuery setLimit() setLimit($limit)
 * @method \Application\Query\ChannelQuery setOffset() setOffset($offset)
 * @method \Application\Query\ChannelQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\ChannelQuery distinct()
 * @method \Application\Query\ChannelQuery select()
 * @method \Application\Query\ChannelQuery addColumns() addColumns($columns)
 * @method \Application\Query\ChannelQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\ChannelQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\ChannelQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\ChannelQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\ChannelQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\ChannelQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\ChannelQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class ChannelQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('ChannelCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Channel::TABLENAME, "Channel");

        $defaultColumn = array("Channel.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelQuery
     */
    public function pk($value){
        $this->filter(array(
            Channel::ID_CHANNEL => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Channel::ID_CHANNEL, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelQuery
     */
    public function filter($fields, $prefix = 'Channel'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Channel')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_channel']) && !empty($fields['id_channel']) ){
            $criteria->add(Channel::ID_CHANNEL, $fields['id_channel']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Channel::NAME, $fields['name']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Channel::STATUS, $fields['status']);
        }
        if( isset($fields['canal_acl']) && !empty($fields['canal_acl']) ){
        	$criteria->add(Channel::CANAL_ACL, $fields['canal_acl']);
        }
        if( isset($fields['canal_recl']) && !empty($fields['canal_recl']) ){
        	$criteria->add(Channel::CANAL_RECL, $fields['canal_recl']);
        }
        if( isset($fields['reopen']) && !empty($fields['reopen']) ){
        	$criteria->add(Channel::REOPEN, $fields['reopen']);
        }
        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\ChannelQuery
     */
    public function actives(){
        return $this->filter(array(
            Channel::STATUS => Channel::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\ChannelQuery
     */
    public function inactives(){
        return $this->filter(array(
            Channel::STATUS => Channel::$Status['Inactive'],
        ));
    }


}