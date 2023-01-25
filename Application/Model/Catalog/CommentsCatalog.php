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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\Comments;
use Application\Model\Factory\CommentsFactory;
use Application\Model\Collection\CommentsCollection;
use Application\Model\Exception\CommentsException;
use Application\Model\Bean\Bean;
use Application\Query\CommentsQuery;
use Query\Query;

/**
 *
 * CommentsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Comments getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CommentsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CommentsCatalog extends AbstractCatalog {



    /**
     *
     * Validate Query
     * @param CommentsQuery $query
     * @throws RoundException
     */
//    protected function validateQuery(Query $query)
//    {
//        if( !($query instanceof CommentsQuery) ){
//            $this->throwException("No es un Query valido");
//        }
//    }
//    
//    /**
//     * @return \Application\Model\Metadata\CommentsMetadata
//     */
//    protected static function getMetadata(){
//        return \Application\Model\Metadata\CommentsMetadata::getInstance();
//    }
    public function create($comment)
    {
        $this->validateBean($comment);
        try
        {
            $data = $comment->toArrayFor(
                array('id_base_ticket','id_user_origin','id_user_destiny','creation_date','note',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Comments::TABLENAME, $data);
            $comment->setIdComment($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Comments can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Channel en la base de datos
     * @param Channel $channel Objeto Channel
     */
    public function update($comment)
    {
        $this->validateBean($comment);
        try
        {
            $data = $comment->toArrayFor(
                array('id_base_ticket','id_user_origin','id_user_destiny','creation_date','note',)
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Comments::TABLENAME, $data, "id_comments = '{$data->getIdComment()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Comments can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Channel a partir de su Id
     * @param int $idChannel
     */
    public function deleteById($idComment)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_comment = ?', $idComment));
            $this->getDb()->delete(Comments::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Comments can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ChannelCollection
     */
    protected function makeCollection(){
        return new CommentsCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Channel
     */
    protected function makeBean($resultset){
        return CommentsFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ChannelQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CommentsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Channel
     * @param Channel $channel
     * @throws Exception
     */
    protected function validateBean($comment = null){
        if( !($comment instanceof Comments) ){
            $this->throwException("passed parameter isn't a Comments instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CommentsException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CommentsException($message);
        }
    }

 }