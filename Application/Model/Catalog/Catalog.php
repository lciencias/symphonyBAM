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

use Application\Storage\Storage;
use Query\Query;

/**
 *
 * Catalog
 *
 * @category Application\Model\Catalog
 * @author guadalupe, chente
 */
interface Catalog
{

    /**
     * beginTransaction
     */
    public function beginTransaction();

    /**
     * commit
     */
    public function commit();

    /**
     * rollBack
     */
    public function rollBack();

    /**
     * Guarda en la base de datos
     * @param Bean  Un bean para guardar
     */
    public function create($object);

    /**
     * Actualiza el objeto en la base de datos
     * @param Bean Un bean para actualizar
     */
    public function update($object);

    /**
     * Elimina de la base de datos por medio de llave primaria
     * @param int $idObject El id del bean que se eliminara
     */
    public function deleteById($idObject);

    /**
     * getByQuery
     * @param Query $query
     * @param Storage $storage
     * @return \Application\Model\Collection\Collection
     */
    public function getByQuery(Query $query, Storage $storage = null);

    /**
     * @param Query $query
     * @param Storage $storage
     * @return \Application\Model\Bean\Bean
     */
    public function getOneByQuery(Query $query, Storage $storage = null);

    /**
     * @param Query $query
     * @param Storage $storage
     * @return array
     */
    public function fetchAll(Query $query, Storage $storage = null);

    /**
     * @param Query $query
     * @param Storage $storage
     * @return array
     */
    public function fetchCol(Query $query, Storage $storage = null);

    /**
     * @param Query $query
     * @param Storage $storage
     * @return mixed
     */
    public function fetchOne(Query $query, Storage $storage = null);

    /**
     * @param Query $query
     * @param Storage $storage
     * @return mixed
     */
    public function fetchPairs(Query $query, Storage $storage = null);

}