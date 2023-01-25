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

use Application\Model\Bean\Attachment;

/**
 *
 * AttachmentCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\Attachment current()
 * @method \Application\Model\Bean\Attachment read()
 * @method \Application\Model\Bean\Attachment getOne()
 * @method \Application\Model\Bean\Attachment getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\AttachmentCollection intersect() intersect(\Application\Model\Collection\AttachmentCollection $collection)
 * @method \Application\Model\Collection\AttachmentCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\AttachmentCollection merge() merge(\Application\Model\Collection\AttachmentCollection $collection)
 * @method \Application\Model\Collection\AttachmentCollection diff() diff(\Application\Model\Collection\AttachmentCollection $collection)
 * @method \Application\Model\Collection\AttachmentCollection copy()
 */
class AttachmentCollection extends FileCollection{

    /**
     *
     * @param Attachment $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Attachment) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Attachment");
        }
    }


}