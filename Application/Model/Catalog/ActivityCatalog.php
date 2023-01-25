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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\Activity;
use Application\Model\Factory\ActivityFactory;
use Application\Model\Collection\ActivityCollection;
use Application\Model\Exception\ActivityException;
use Application\Model\Bean\Bean;
use Application\Query\ActivityQuery;
use Query\Query;

/**
 *
 * ActivityCatalog
 *
 * @package Application\Model\Catalog
 * @author jose luis
 * @method \Application\Model\Bean\Activity getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ActivityCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ActivityCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Activity a la base de datos
     * @param Activity $activity Objeto Activity
     */
    public function create($activity)
    {
        $this->validateBean($activity);
        try
        {
            $data = $activity->toArrayFor(
                array('id_base_ticket', 'id_user', 'start_date', 'end_date', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Activity::TABLENAME, $data);
            $activity->setIdActivity($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Activity can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Activity en la base de datos
     * @param Activity $activity Objeto Activity
     */
    public function update($activity)
    {
        $this->validateBean($activity);
        try
        {
            $data = $activity->toArrayFor(
                array('id_base_ticket', 'id_user', 'start_date', 'end_date', 'note', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Activity::TABLENAME, $data, "id_activity = '{$activity->getIdActivity()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Activity can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Activity a partir de su Id
     * @param int $idActivity
     */
    public function deleteById($idActivity)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_activity = ?', $idActivity));
            $this->getDb()->delete(Activity::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Activity can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\ActivityCollection
     */
    protected function makeCollection(){
        return new ActivityCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Activity
     */
    protected function makeBean($resultset){
        return ActivityFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param ActivityQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ActivityQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Activity
     * @param Activity $activity
     * @throws Exception
     */
    protected function validateBean($activity = null){
        if( !($activity instanceof Activity) ){
            $this->throwException("passed parameter isn't a Activity instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new ActivityException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new ActivityException($message);
        }
    }

 }