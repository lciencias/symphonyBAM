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
use Application\Model\Bean\Category;
use Application\Model\Factory\CategoryFactory;
use Application\Model\Collection\CategoryCollection;
use Application\Model\Exception\CategoryException;
use Application\Model\Bean\Bean;
use Application\Query\CategoryQuery;
use Query\Query;

/**
 *
 * CategoryCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Category getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CategoryCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CategoryCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Category a la base de datos
     * @param Category $category Objeto Category
     */
    public function create($category)
    {
        $this->validateBean($category);
        try
        {
            $data = $category->toArrayFor(
                array('id_company', 'id_group', 'id_escalation', 'id_service_level', 'id_parent', 'name', 'status', 'is_leaf', 'note', )
            );
            if( null == $data['id_parent'] ){
                $data['id_parent'] = new \Zend_Db_Expr('null');
            }
            $this->getDb()->insert(Category::TABLENAME, $data);
            $category->setIdCategory($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Category can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Category en la base de datos
     * @param Category $category Objeto Category
     */
    public function update($category)
    {
        $this->validateBean($category);
        try
        {
            $data = $category->toArrayFor(
                array('id_company', 'id_group', 'id_escalation', 'id_service_level', 'id_parent', 'name', 'status', 'is_leaf', 'note', )
            );
            if( null == $data['id_parent'] ){
                $data['id_parent'] = new \Zend_Db_Expr('null');
            }
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Category::TABLENAME, $data, "id_category = '{$category->getIdCategory()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Category can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Category a partir de su Id
     * @param int $idCategory
     */
    public function deleteById($idCategory)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_category = ?', $idCategory));
            $this->getDb()->delete(Category::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Category can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CategoryCollection
     */
    protected function makeCollection(){
        return new CategoryCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Category
     */
    protected function makeBean($resultset){
        return CategoryFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CategoryQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CategoryQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Category
     * @param Category $category
     * @throws Exception
     */
    protected function validateBean($category = null){
        if( !($category instanceof Category) ){
            $this->throwException("passed parameter isn't a Category instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CategoryException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CategoryException($message);
        }
    }

 }