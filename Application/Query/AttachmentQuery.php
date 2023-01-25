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

use Query\Query;
use Application\Model\Catalog\AttachmentCatalog;
use Application\Model\Bean\Attachment;


/**
 * Application\Query\AttachmentQuery
 *
 * @method \Application\Query\AttachmentQuery pk() pk(int $primaryKey)
 * @method \Application\Query\AttachmentQuery useMemoryCache()
 * @method \Application\Query\AttachmentQuery useFileCache()
 * @method \Application\Model\Collection\AttachmentCollection find()
 * @method \Application\Model\Bean\Attachment findOne()
 * @method \Application\Model\Bean\Attachment findOneOrElse() findOneOrElse(Attachment $alternative)
 * @method \Application\Model\Bean\Attachment findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Attachment findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Attachment findByPKOrElse() findByPKOrElse($pk, Attachment $alternative)
 * @method \Application\Model\Bean\Attachment findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\AttachmentQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\AttachmentQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\AttachmentQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\AttachmentQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\AttachmentQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\AttachmentQuery removeJoins()
 * @method \Application\Query\AttachmentQuery removeJoin() removeJoin($table)
 * @method \Application\Query\AttachmentQuery from() from($table, $alias = null)
 * @method \Application\Query\AttachmentQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\AttachmentQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\AttachmentQuery bind() bind($parameters)
 * @method \Application\Query\AttachmentQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\AttachmentQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\AttachmentQuery setLimit() setLimit($limit)
 * @method \Application\Query\AttachmentQuery setOffset() setOffset($offset)
 * @method \Application\Query\AttachmentQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\AttachmentQuery distinct()
 * @method \Application\Query\AttachmentQuery select()
 * @method \Application\Query\AttachmentQuery addColumns() addColumns($columns)
 * @method \Application\Query\AttachmentQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\AttachmentQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\AttachmentQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\AttachmentQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\AttachmentQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\AttachmentQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\AttachmentQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class AttachmentQuery extends FileQuery{

    /**
     *
     * @return \Application\Model\Catalog\AttachmentCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('AttachmentCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Attachment::TABLENAME, "Attachment");
        $this->innerJoinFile();

        $defaultColumn = array("Attachment.*");
        $defaultColumn[] = "File.*";
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\AttachmentQuery
     */
    public function pk($value){
        $this->filter(array(
            Attachment::ID_ATTACHMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Attachment::ID_ATTACHMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\AttachmentQuery
     */
    public function filter($fields, $prefix = 'Attachment'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Attachment')
    {
        parent::build($query, $fields);

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_attachment']) && !empty($fields['id_attachment']) ){
            $criteria->add(Attachment::ID_ATTACHMENT, $fields['id_attachment']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Attachment::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_file']) && !empty($fields['id_file']) ){
            $criteria->add(Attachment::ID_FILE, $fields['id_file']);
        }
        if( isset($fields['id_user']) && !empty($fields['id_user']) ){
            $criteria->add(Attachment::ID_USER, $fields['id_user']);
        }
        if( isset($fields['created_at']) && !empty($fields['created_at']) ){
            $criteria->add(Attachment::CREATED_AT, $fields['created_at']);
        }

        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AttachmentQuery
     */
    public function innerJoinBaseTicket($alias = 'Attachment', $aliasForeignTable = 'BaseTicket')
    {
        $this->innerJoinOn(\Application\Model\Bean\BaseTicket::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\AttachmentQuery
     */
    public function innerJoinFile($alias = 'Attachment', $aliasForeignTable = 'File')
    {
        $this->innerJoinOn(\Application\Model\Bean\File::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_file'), array($aliasForeignTable, 'id_file'));

        return $this;
    }


}