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

use Application\Model\Catalog\AttachmentCatalog;
use Application\Model\Factory\AttachmentFactory;
use Application\Model\Bean\Attachment;
use Application\Query\AttachmentQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;
use Application\Query\TicketQuery;
use Application\File\FileUploader;

/**
 *
 * @author chente
 */
class AttachmentController extends CrudController
{

	/**
	 * Metodo index
	 */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * 
     * {@inheritDoc}
     * @see \Application\Controller\CrudController::listAction()
     */
    public function listAction(){}

    /**
     *
     * @return array
     */
    public function newAction(){}

    /**
     *
     * @return array
     */
    public function editAction()
    {
    }

    /**
     * @module Tickets
     * @action Upload Attachment
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $ticket = TicketQuery::create()->findByPKOrThrow($params['id_ticket'], "The ticket not exists");

           try
           {
               $this->getAttachmentCatalog()->beginTransaction();

               $fileUploader = new FileUploader('file');
               if( !$fileUploader->isUpload() ){
                   throw new Exception("El archivo es invalido");
               }

               $uploadDir = 'public/uploads/tickets/id'.$ticket->getIdBaseTicket();
               $fileUploader->saveFile($uploadDir, false);

               $params['uri'] = $uploadDir . $fileUploader->getFileName();
               $params['original_name'] = $fileUploader->getOriginalName();
               $params['id_base_ticket'] = $ticket->getIdBaseTicket();
               $attachment = AttachmentFactory::createFromArray($params);
               $attachment->setIdUser($this->getUser()->getIdUser());

               $this->getAttachmentCatalog()->create($attachment);

               $this->getAttachmentCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("Has been saved successfully"));
           }
           catch(Exception $e)
           {
               $this->getAttachmentCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect($this->getUser()->getFullLastUrl());
    }

    /**
     *
     * @return array
     */
    public function updateAction()
    {
    }

    /**
     *
     */
    public function deleteAction(){
    }


    /**
     * @return \Application\Model\Catalog\AttachmentCatalog
     */
    protected function getAttachmentCatalog(){
        return $this->getContainer()->get('AttachmentCatalog');
    }

}
