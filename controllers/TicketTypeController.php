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

use Application\Model\Catalog\TicketTypeCatalog;
use Application\Model\Factory\TicketTypeFactory;
use Application\Model\Bean\TicketType;
use Application\Query\TicketTypeQuery;
use Application\Form\TicketTypeForm;
use Application\Model\Bean\TicketTypeLog;
use Application\Model\Factory\TicketTypeLogFactory;
use Application\Model\Catalog\TicketTypeLogCatalog;
use Application\Query\TicketTypeLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class TicketTypeController extends CrudController
{

    /**
     * @module Ticket type
     * @action Lis
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Ticket type
     * @action Lis
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = TicketTypeQuery::create()->filter($post)->count();
        $this->view->ticketTypes = $ticketTypes = TicketTypeQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(TicketType::$Status);
    }

    /**
     * @module Ticket type
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('ticket-type', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Ticket type
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $ticketType = TicketTypeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TicketType with id {$id}"));

        $url = $this->generateUrl('ticket-type', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($ticketType->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Ticket type
     * @action Create
     * @return array
     */
    public function createAction()
    {
        $form = $this->getForm();
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           if( !$form->isValid($params) ){
               $this->view->setTpl("New");
               $this->view->form = $form;
               return;
           }

           try
           {
               $this->getTicketTypeCatalog()->beginTransaction();

               $ticketType = TicketTypeFactory::createFromArray($form->getValues());
               $this->getTicketTypeCatalog()->create($ticketType);
               $this->newLogForCreate($ticketType);

               $this->getTicketTypeCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Ticket type was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getTicketTypeCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('ticket-type/list');
    }

    /**
     * @module Ticket type
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $form = $this->getForm();
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            $id = $this->getRequest()->getParam('id');
            $ticketType = TicketTypeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TicketType with id {$id}"));

            try
            {
                $this->getTicketTypeCatalog()->beginTransaction();

                TicketTypeFactory::populate($ticketType, $form->getValues());
                $this->getTicketTypeCatalog()->update($ticketType);
                $this->newLogForUpdate($ticketType);

                $this->getTicketTypeCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Ticket type was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getTicketTypeCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('ticket-type/list');
    }

    /**
     * @module Ticket type
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $ticketType = TicketTypeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TicketType with id {$id}"));

        try
        {
            $this->getTicketTypeCatalog()->beginTransaction();

            $ticketType->setStatus(TicketType::$Status['Inactive']);
            $this->getTicketTypeCatalog()->update($ticketType);
            $this->newLogForDelete($ticketType);

            $this->getTicketTypeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Ticket type was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getTicketTypeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('ticket-type/list');
    }

    /**
     * @module Ticket type
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $ticketType = TicketTypeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TicketType with id {$id}"));

        try
        {
            $this->getTicketTypeCatalog()->beginTransaction();

            $ticketType->setStatus(TicketType::$Status['Active']);
            $this->getTicketTypeCatalog()->update($ticketType);
            $this->newLogForReactivate($ticketType);

            $this->getTicketTypeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Ticket type was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getTicketTypeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('ticket-type/list');
    }

    /**
     * @module Ticket type
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $ticketType = TicketTypeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TicketType with id {$id}"));
        $this->view->ticketTypeLogs = $logs = TicketTypeLogQuery::create()->whereAdd('id_ticket_type', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param TicketType $ticketType
     * @return \Application\Model\Bean\TicketTypeLog
     */
    protected function newLogForCreate(TicketType $ticketType){
        return $this->newLog($ticketType, \Application\Model\Bean\TicketTypeLog::$EventTypes['Create'] );
    }

    /**
     * @param TicketType $ticketType
     * @return \Application\Model\Bean\TicketTypeLog
     */
    protected function newLogForUpdate(TicketType $ticketType){
        return $this->newLog($ticketType, \Application\Model\Bean\TicketTypeLog::$EventTypes['Update'] );
    }

    /**
     * @param TicketType $ticketType
     * @return \Application\Model\Bean\TicketTypeLog
     */
    protected function newLogForDelete(TicketType $ticketType){
        return $this->newLog($ticketType, TicketTypeLog::$EventTypes['Delete'] );
    }

    /**
     * @param TicketType $ticketType
     * @return \Application\Model\Bean\TicketTypeLog
     */
    protected function newLogForReactivate(TicketType $ticketType){
        return $this->newLog($ticketType, TicketTypeLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\TicketTypeLog
     */
    private function newLog(TicketType $ticketType, $eventType){
        $now = \Zend_Date::now();
        $log = TicketTypeLogFactory::createFromArray(array(
            'id_ticket_type' => $ticketType->getIdTicketType(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_log' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('TicketTypeLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\TicketTypeCatalog
     */
    protected function getTicketTypeCatalog(){
        return $this->getContainer()->get('TicketTypeCatalog');
    }

    /**
     *
     * @return Application\Form\TicketTypeForm
     */
    protected function getForm()
    {
        $form = new TicketTypeForm();
        $submit = new Zend_Form_Element_Submit("send");
        $submit->setLabel($this->i18n->_("Save"));
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setLabel($this->i18n->_("Cancel"));
        $form->addElement($submit)
            ->addElement($cancel)
            ->setMethod('post');
        $form->twitterDecorators();
        return $form;
    }

}
