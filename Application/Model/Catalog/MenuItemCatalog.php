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
use Application\Model\Bean\MenuItem;
use Application\Model\Factory\MenuItemFactory;
use Application\Model\Collection\MenuItemCollection;
use Application\Model\Exception\MenuItemException;
use Application\Model\Bean\Bean;
use Application\Query\MenuItemQuery;
use Query\Query;

/**
 *
 * MenuItemCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\MenuItem getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\MenuItemCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class MenuItemCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un MenuItem a la base de datos
     * @param MenuItem $menuItem Objeto MenuItem
     */
    public function create($menuItem)
    {
        $this->validateBean($menuItem);
        try
        {
            $data = $menuItem->toArrayFor(
                array('id_parent', 'id_action', 'name', 'order', 'icon', 'icon_size')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(MenuItem::TABLENAME, $data);
            $menuItem->setIdMenuItem($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The MenuItem can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un MenuItem en la base de datos
     * @param MenuItem $menuItem Objeto MenuItem
     */
    public function update($menuItem)
    {
        $this->validateBean($menuItem);
        try
        {
            $data = $menuItem->toArrayFor(
                array('id_parent', 'id_action', 'name', 'order', 'icon', 'icon_size')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(MenuItem::TABLENAME, $data, "id_menu_item = '{$menuItem->getIdMenuItem()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The MenuItem can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un MenuItem a partir de su Id
     * @param int $idMenuItem
     */
    public function deleteById($idMenuItem)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_menu_item = ?', $idMenuItem));
            $this->getDb()->delete(MenuItem::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The MenuItem can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\MenuItemCollection
     */
    protected function makeCollection(){
        return new MenuItemCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\MenuItem
     */
    protected function makeBean($resultset){
        return MenuItemFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param MenuItemQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof MenuItemQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate MenuItem
     * @param MenuItem $menuItem
     * @throws Exception
     */
    protected function validateBean($menuItem = null){
        if( !($menuItem instanceof MenuItem) ){
            $this->throwException("passed parameter isn't a MenuItem instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new MenuItemException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new MenuItemException($message);
        }
    }

 }