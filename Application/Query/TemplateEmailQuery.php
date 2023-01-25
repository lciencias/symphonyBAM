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
use Application\Model\Catalog\TemplateEmailCatalog;
use Application\Model\Bean\TemplateEmail;

use Application\Query\BaseQuery;

/**
 * Application\Query\TemplateEmailQuery
 *
 * @method \Application\Query\TemplateEmailQuery pk() pk(int $primaryKey)
 * @method \Application\Query\TemplateEmailQuery useMemoryCache()
 * @method \Application\Query\TemplateEmailQuery useFileCache()
 * @method \Application\Model\Collection\TemplateEmailCollection find()
 * @method \Application\Model\Bean\TemplateEmail findOne()
 * @method \Application\Model\Bean\TemplateEmail findOneOrElse() findOneOrElse(TemplateEmail $alternative)
 * @method \Application\Model\Bean\TemplateEmail findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\TemplateEmail findByPK() findByPK($pk)
 * @method \Application\Model\Bean\TemplateEmail findByPKOrElse() findByPKOrElse($pk, TemplateEmail $alternative)
 * @method \Application\Model\Bean\TemplateEmail findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\TemplateEmailQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\TemplateEmailQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\TemplateEmailQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\TemplateEmailQuery removeJoins()
 * @method \Application\Query\TemplateEmailQuery removeJoin() removeJoin($table)
 * @method \Application\Query\TemplateEmailQuery from() from($table, $alias = null)
 * @method \Application\Query\TemplateEmailQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\TemplateEmailQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\TemplateEmailQuery bind() bind($parameters)
 * @method \Application\Query\TemplateEmailQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\TemplateEmailQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\TemplateEmailQuery setLimit() setLimit($limit)
 * @method \Application\Query\TemplateEmailQuery setOffset() setOffset($offset)
 * @method \Application\Query\TemplateEmailQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\TemplateEmailQuery distinct()
 * @method \Application\Query\TemplateEmailQuery select()
 * @method \Application\Query\TemplateEmailQuery addColumns() addColumns($columns)
 * @method \Application\Query\TemplateEmailQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\TemplateEmailQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\TemplateEmailQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\TemplateEmailQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\TemplateEmailQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\TemplateEmailQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\TemplateEmailQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class TemplateEmailQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\TemplateEmailCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('TemplateEmailCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(TemplateEmail::TABLENAME, "TemplateEmail");

        $defaultColumn = array("TemplateEmail.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\TemplateEmailQuery
     */
    public function pk($value){
        $this->filter(array(
            TemplateEmail::ID_TEMPLATE_EMAIL => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(TemplateEmail::ID_TEMPLATE_EMAIL, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\TemplateEmailQuery
     */
    public function filter($fields, $prefix = 'TemplateEmail'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'TemplateEmail')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_template_email']) && !empty($fields['id_template_email']) ){
            $criteria->add(TemplateEmail::ID_TEMPLATE_EMAIL, $fields['id_template_email']);
        }
        if( isset($fields['id_company']) && !empty($fields['id_company']) ){
            $criteria->add(TemplateEmail::ID_COMPANY, $fields['id_company']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(TemplateEmail::NAME, $fields['name']);
        }
        if( isset($fields['subject']) && !empty($fields['subject']) ){
            $criteria->add(TemplateEmail::SUBJECT, $fields['subject']);
        }
        if( isset($fields['body']) && !empty($fields['body']) ){
            $criteria->add(TemplateEmail::BODY, $fields['body']);
        }
        if( isset($fields['event']) && !empty($fields['event']) ){
            $criteria->add(TemplateEmail::EVENT, $fields['event']);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(TemplateEmail::STATUS, $fields['status']);
        }
        if( isset($fields['to_employee']) && !empty($fields['to_employee']) ){
            $criteria->add(TemplateEmail::TO_EMPLOYEE, $fields['to_employee']);
        }
        if( isset($fields['to_user']) && !empty($fields['to_user']) ){
            $criteria->add(TemplateEmail::TO_USER, $fields['to_user']);
        }
        if( isset($fields['to_group']) && !empty($fields['to_group']) ){
            $criteria->add(TemplateEmail::TO_GROUP, $fields['to_group']);
        }
        if( isset($fields['language']) && !empty($fields['language']) ){
            $criteria->add(TemplateEmail::LANGUAGE, $fields['language']);
        }
        if( isset($fields['kind_of_ticket']) && !empty($fields['kind_of_ticket']) ){
        	$criteria->add(TemplateEmail::KIND_OF_TICKET, $fields['kind_of_ticket']);
        }

        $criteria->endPrefix();
    }

    /**
     * @return \Application\Query\TemplateEmailQuery
     */
    public function actives(){
        return $this->filter(array(
            TemplateEmail::STATUS => TemplateEmail::$Status['Active'],
        ));
    }

    /**
     * @return \Application\Query\TemplateEmailQuery
     */
    public function inactives(){
        return $this->filter(array(
            TemplateEmail::STATUS => TemplateEmail::$Status['Inactive'],
        ));
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\TemplateEmailQuery
     */
    public function innerJoinCompany($alias = 'TemplateEmail', $aliasForeignTable = 'Company')
    {
        $this->innerJoinOn(\Application\Model\Bean\Company::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_company'), array($aliasForeignTable, 'id_company'));

        return $this;
    }


}