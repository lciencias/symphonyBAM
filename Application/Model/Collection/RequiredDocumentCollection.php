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

use Application\Model\Bean\RequiredDocument;

/**
 *
 * RequiredDocumentCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\RequiredDocument current()
 * @method \Application\Model\Bean\RequiredDocument read()
 * @method \Application\Model\Bean\RequiredDocument getOne()
 * @method \Application\Model\Bean\RequiredDocument getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\RequiredDocumentCollection intersect() intersect(\Application\Model\Collection\RequiredDocumentCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\RequiredDocumentCollection merge() merge(\Application\Model\Collection\RequiredDocumentCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentCollection diff() diff(\Application\Model\Collection\RequiredDocumentCollection $collection)
 * @method \Application\Model\Collection\RequiredDocumentCollection copy()
 */
class RequiredDocumentCollection extends Collection{

    /**
     *
     * @param RequiredDocument $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof RequiredDocument) ){
            throw new \InvalidArgumentException("Debe de ser un objecto RequiredDocument");
        }
    }


}