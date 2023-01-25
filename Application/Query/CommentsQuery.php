<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Metadata\CommentsMetadata;
use Application\Model\Bean\Comments;

use Application\Query\BaseQuery;
use Application\Storage\StorageFactory;
/**
 * Application\Query\CommentsQuery
 *
 * @method \Application\Query\CommentsQuery pk() pk(int $primaryKey)
 * @method \Application\Query\CommentsQuery useMemoryCache()
 * @method \Application\Query\CommentsQuery useFileCache()
 * @method \Application\Model\Collection\CommentsCollection find()
 * @method \Application\Model\Bean\Comments findOne()
 * @method \Application\Model\Bean\Comments findOneOrElse() findOneOrElse(Comments $alternative)
 * @method \Application\Model\Bean\Comments findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Comments findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Comments findByPKOrElse() findByPKOrElse($pk, Comments $alternative)
 * @method \Application\Model\Bean\Comments findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\CommentsQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\CommentsQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\CommentsQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\CommentsQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\CommentsQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\CommentsQuery removeJoins()
 * @method \Application\Query\CommentsQuery removeJoin() removeJoin($table)
 * @method \Application\Query\CommentsQuery from() from($table, $alias = null)
 * @method \Application\Query\CommentsQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\CommentsQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\CommentsQuery bind() bind($parameters)
 * @method \Application\Query\CommentsQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\CommentsQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\CommentsQuery setLimit() setLimit($limit)
 * @method \Application\Query\CommentsQuery setOffset() setOffset($offset)
 * @method \Application\Query\CommentsQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\CommentsQuery distinct()
 * @method \Application\Query\CommentsQuery select()
 * @method \Application\Query\CommentsQuery pk() pk($id)
 * @method \Application\Query\CommentsQuery filter() filter($fields, $prefix = null)
 * @method \Application\Query\CommentsQuery addColumns() addColumns($columns)
 * @method \Application\Query\CommentsQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\CommentsQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\CommentsQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\CommentsQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\CommentsQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\CommentsQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\CommentsQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class CommentsQuery extends BaseQuery{

    /**
     * @return \Application\Model\Metadata\CommentsMetadata
     */
    /*protected static function getMetadata(){
        return CommentsMetadata::getInstance();
    }*/



    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CommentsQuery
     */
    /*public function innerJoin($alias = 'Comments', $aliasForeignTable = '')
    {
        $this->innerJoinOn(TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_base_ticket'), array($aliasForeignTable, 'id_base_ticket'));

        return $this;
    }*/

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CommentsQuery
     */
    /*public function innerJoin($alias = 'Comments', $aliasForeignTable = '')
    {
        $this->innerJoinOn(TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user_origin'), array($aliasForeignTable, 'id_user'));

        return $this;
    }*/

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\CommentsQuery
     */
    /*public function innerJoin($alias = 'Comments', $aliasForeignTable = '')
    {
        $this->innerJoinOn(TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_user_destiny'), array($aliasForeignTable, 'id_user'));

        return $this;
    }*/
    
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('CommentsCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Comments::TABLENAME, "Comments");

        $defaultColumn = array("Comments.*");
        $this->setDefaultColumn($defaultColumn);
        $this->setStorage(StorageFactory::create('memory'));
    }

    /**
     * @param mixed $value
     * @return Application\Query\ChannelQuery
     */
    public function pk($value){
        $this->filter(array(
            Comments::ID_COMMENT => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Comments::ID_COMMENT, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\ChannelQuery
     */
    public function filter($fields, $prefix = 'Comments'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Comments')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_comment']) && !empty($fields['id_comment']) ){
            $criteria->add(Comments::ID_COMMENT, $fields['id_comment']);
        }
        if( isset($fields['id_base_ticket']) && !empty($fields['id_base_ticket']) ){
            $criteria->add(Comments::ID_BASE_TICKET, $fields['id_base_ticket']);
        }
        if( isset($fields['id_user_origin']) && !empty($fields['id_user_origin']) ){
            $criteria->add(Comments::ID_USER_ORIGIN, $fields['id_user_origin']);
        }
        if( isset($fields['id_user_destiny']) && !empty($fields['id_user_destiny']) ){
            $criteria->add(Comments::ID_USER_DESTINY, $fields['id_user_destiny']);
        }
        if( isset($fields['creation_date']) && !empty($fields['creation_date']) ){
            $criteria->add(Comments::CREATION_DATE, $fields['creation_date']);
        }
        if( isset($fields['note']) && !empty($fields['note']) ){
            $criteria->add(Comments::NOTE, $fields['note'], CommentsQuery::LIKE);
        }
        
        $criteria->endPrefix();
    }

    /**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\EmailQuery
     */
    public function innerJoinUsers($alias = 'Comments', $aliasForeignTable = 'Users')
    {
        $this->innerJoinOn('pcs_common_users', 'Comments2Users')
            ->equalFields(array($alias, 'id_user_origin'), array('Comments2Users', 'id_user'));
        
        $this->innerJoinOn('pcs_symphony_employees', 'Users2Employee')
            ->equalFields(array('Comments2Users', 'id_employee'), array('Users2Employee', 'id_employee'));
        
        $this->innerJoinOn('pcs_common_persons', 'Employee2Person')
            ->equalFields(array('Users2Employee', 'id_person'), array('Employee2Person', 'id_person'));

        return $this;
    }
    



}