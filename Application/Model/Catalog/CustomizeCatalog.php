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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\Customize;
use Application\Model\Factory\CustomizeFactory;
use Application\Model\Collection\CustomizeCollection;
use Application\Model\Exception\CustomizeException;
use Application\Model\Bean\Bean;
use Application\Query\CustomizeQuery;
use Query\Query;

/**
 *
 * CustomizeCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Customize getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CustomizeCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CustomizeCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Customize a la base de datos
     * @param Customize $customize Objeto Customize
     */
    public function create($customize)
    {
        $this->validateBean($customize);
        try
        {
            $data = $customize->toArrayFor(
                array('id_company', 'logo', 'background_color', 'forward_color', 'font_size', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Customize::TABLENAME, $data);
            $customize->setIdPcsCommonCustomize($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Customize can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Customize en la base de datos
     * @param Customize $customize Objeto Customize
     */
    public function update($customize)
    {
        $this->validateBean($customize);
        try
        {
            $data = $customize->toArrayFor(
                array('id_company', 'logo', 'background_color', 'forward_color', 'font_size', )
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Customize::TABLENAME, $data, "id_pcs_common_customize = '{$customize->getIdPcsCommonCustomize()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Customize can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Customize a partir de su Id
     * @param int $idPcsCommonCustomize
     */
    public function deleteById($idPcsCommonCustomize)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_pcs_common_customize = ?', $idPcsCommonCustomize));
            $this->getDb()->delete(Customize::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Customize can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CustomizeCollection
     */
    protected function makeCollection(){
        return new CustomizeCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Customize
     */
    protected function makeBean($resultset){
        return CustomizeFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CustomizeQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CustomizeQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Customize
     * @param Customize $customize
     * @throws Exception
     */
    protected function validateBean($customize = null){
        if( !($customize instanceof Customize) ){
            $this->throwException("passed parameter isn't a Customize instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CustomizeException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CustomizeException($message);
        }
    }

 }