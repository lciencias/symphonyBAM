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

namespace Application\Model\Collection;

use Application\Model\Bean\Document;

/**
 *
 * DocumentCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Document current()
 * @method \Application\Model\Bean\Document read()
 * @method \Application\Model\Bean\Document getOne()
 * @method \Application\Model\Bean\Document getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\DocumentCollection intersect() intersect(\Application\Model\Collection\DocumentCollection $collection)
 * @method \Application\Model\Collection\DocumentCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\DocumentCollection merge() merge(\Application\Model\Collection\DocumentCollection $collection)
 * @method \Application\Model\Collection\DocumentCollection diff() diff(\Application\Model\Collection\DocumentCollection $collection)
 * @method \Application\Model\Collection\DocumentCollection copy()
 */
class DocumentCollection extends Collection{

    /**
     *
     * @param Document $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Document) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Document");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Document $document){
            return array( $document->getIdDocument() => $document->getName() );
        });
    }

}