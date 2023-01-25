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
use Application\Model\Bean\ReasonProducts;
use Application\Model\Factory\ReasonProductsFactory;
use Application\Model\Collection\ReasonProductsCollection;
use Application\Model\Exception\ReasonProductsException;
use Application\Model\Bean\Bean;
use Application\Query\ReasonProductsQuery;
use Query\Query;

/**
 *
 * ReasonProductsCatalog
 *
 * @package Application\Model\Catalog
 * @author Luis Hernandez
 * @method \Application\Model\Bean\ReasonProducts getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\ReasonProductsCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class ReasonProductsCatalog extends AbstractCatalog {



    /**
     *
     * Validate Query
     * @param ReasonProductsQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof ReasonProductsQuery) ){
            $this->throwException("No es un Query valido");
        }
    }
    
    /**
     * @return \Application\Model\Metadata\ReasonProductsMetadata
     */
    protected static function getMetadata(){
        return \Application\Model\Metadata\ReasonProductsMetadata::getInstance();
    }

 }