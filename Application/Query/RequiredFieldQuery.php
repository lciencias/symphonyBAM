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

use Application\Model\Bean\Field;

use Application\Model\Bean\ClientCategory;

use Query\Query;
use Application\Model\Catalog\RequiredFieldCatalog;
use Application\Model\Bean\RequiredField;

use Application\Query\BaseQuery;

/**
 * Application\Query\RequiredFieldQuery
 *
 * @method \Application\Query\RequiredFieldQuery pk() pk(int $primaryKey)
 * @method \Application\Query\RequiredFieldQuery useMemoryCache()
 * @method \Application\Query\RequiredFieldQuery useFileCache()
 * @method \Application\Model\Collection\RequiredFieldCollection find()
 * @method \Application\Model\Bean\RequiredField findOne()
 * @method \Application\Model\Bean\RequiredField findOneOrElse() findOneOrElse(RequiredField $alternative)
 * @method \Application\Model\Bean\RequiredField findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\RequiredField findByPK() findByPK($pk)
 * @method \Application\Model\Bean\RequiredField findByPKOrElse() findByPKOrElse($pk, RequiredField $alternative)
 * @method \Application\Model\Bean\RequiredField findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\RequiredFieldQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\RequiredFieldQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\RequiredFieldQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\RequiredFieldQuery removeJoins()
 * @method \Application\Query\RequiredFieldQuery removeJoin() removeJoin($table)
 * @method \Application\Query\RequiredFieldQuery from() from($table, $alias = null)
 * @method \Application\Query\RequiredFieldQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\RequiredFieldQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\RequiredFieldQuery bind() bind($parameters)
 * @method \Application\Query\RequiredFieldQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\RequiredFieldQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\RequiredFieldQuery setLimit() setLimit($limit)
 * @method \Application\Query\RequiredFieldQuery setOffset() setOffset($offset)
 * @method \Application\Query\RequiredFieldQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\RequiredFieldQuery distinct()
 * @method \Application\Query\RequiredFieldQuery select()
 * @method \Application\Query\RequiredFieldQuery addColumns() addColumns($columns)
 * @method \Application\Query\RequiredFieldQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\RequiredFieldQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\RequiredFieldQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\RequiredFieldQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\RequiredFieldQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\RequiredFieldQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\RequiredFieldQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class RequiredFieldQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\RequiredFieldCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('RequiredFieldCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(RequiredField::TABLENAME, "RequiredField");

        $defaultColumn = array("RequiredField.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\RequiredFieldQuery
     */
    public function pk($value){
        $this->filter(array(
            RequiredField::ID_REQUIRED_FIELD => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(RequiredField::ID_REQUIRED_FIELD, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\RequiredFieldQuery
     */
    public function filter($fields, $prefix = 'RequiredField'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'RequiredField')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_required_field']) && !empty($fields['id_required_field']) ){
            $criteria->add(RequiredField::ID_REQUIRED_FIELD, $fields['id_required_field']);
        }
        if( isset($fields['id_client_category']) && !empty($fields['id_client_category']) ){
            $criteria->add(RequiredField::ID_CLIENT_CATEGORY, $fields['id_client_category']);
        }
        if( isset($fields['id_field']) && !empty($fields['id_field']) ){
            $criteria->add(RequiredField::ID_FIELD, $fields['id_field']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredFieldQuery
     */
    public function innerJoinClientCategory($alias = 'RequiredField', $aliasForeignTable = 'ClientCategory')
    {
        $this->innerJoinOn(ClientCategory::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_client_category'), array($aliasForeignTable, 'id_client_category'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\RequiredFieldQuery
     */
    public function innerJoinField($alias = 'RequiredField', $aliasForeignTable = 'Field')
    {
        $this->innerJoinOn(Field::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_field'), array($aliasForeignTable, 'id_field'));

        return $this;
    }
}