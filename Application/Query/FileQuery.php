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
use Application\Model\Catalog\FileCatalog;
use Application\Model\Bean\File;

use Application\Query\BaseQuery;

/**
 * Application\Query\FileQuery
 *
 * @method \Application\Query\FileQuery pk() pk(int $primaryKey)
 * @method \Application\Query\FileQuery useMemoryCache()
 * @method \Application\Query\FileQuery useFileCache()
 * @method \Application\Model\Collection\FileCollection find()
 * @method \Application\Model\Bean\File findOne()
 * @method \Application\Model\Bean\File findOneOrElse() findOneOrElse(File $alternative)
 * @method \Application\Model\Bean\File findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\File findByPK() findByPK($pk)
 * @method \Application\Model\Bean\File findByPKOrElse() findByPKOrElse($pk, File $alternative)
 * @method \Application\Model\Bean\File findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\FileQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\FileQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\FileQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\FileQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\FileQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\FileQuery removeJoins()
 * @method \Application\Query\FileQuery removeJoin() removeJoin($table)
 * @method \Application\Query\FileQuery from() from($table, $alias = null)
 * @method \Application\Query\FileQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\FileQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\FileQuery bind() bind($parameters)
 * @method \Application\Query\FileQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\FileQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\FileQuery setLimit() setLimit($limit)
 * @method \Application\Query\FileQuery setOffset() setOffset($offset)
 * @method \Application\Query\FileQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\FileQuery distinct()
 * @method \Application\Query\FileQuery select()
 * @method \Application\Query\FileQuery addColumns() addColumns($columns)
 * @method \Application\Query\FileQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\FileQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\FileQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\FileQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\FileQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\FileQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\FileQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class FileQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\FileCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('FileCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(File::TABLENAME, "File");

        $defaultColumn = array("File.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\FileQuery
     */
    public function pk($value){
        $this->filter(array(
            File::ID_FILE => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(File::ID_FILE, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\FileQuery
     */
    public function filter($fields, $prefix = 'File'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'File')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
            $criteria->add(File::ID_FILE, $fields['id_file']);
        }
        if( isset($fields['uri']) && !empty($fields['uri']) ){
            $criteria->add(File::URI, $fields['uri']);
        }
        if( isset($fields['original_name']) && !empty($fields['original_name']) ){
            $criteria->add(File::ORIGINAL_NAME, $fields['original_name']);
        }

        $criteria->endPrefix();
    }


}