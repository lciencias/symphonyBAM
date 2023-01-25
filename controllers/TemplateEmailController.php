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

use Application\Model\Catalog\TemplateEmailCatalog;
use Application\Model\Factory\TemplateEmailFactory;
use Application\Model\Bean\TemplateEmail;
use Application\Query\TemplateEmailQuery;
use Application\Form\TemplateEmailForm;
use Application\Model\Bean\TemplateEmailLog;
use Application\Model\Factory\TemplateEmailLogFactory;
use Application\Model\Catalog\TemplateEmailLogCatalog;
use Application\Query\TemplateEmailLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;
use Application\Event\EmailEvent;
use Application\Model\Bean\Person;

/**
 *
 * @author chente
 */
class TemplateEmailController extends CrudController
{

    /**
     * @module Template Email
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Template Email
     * @action List
     * @return array
     */
    public function listAction()
    {
    	$scripts = array('modules/template-email/list.js');
    	$this->view->scripts = $scripts;
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = TemplateEmailQuery::create()->filter($post)->count();
        $this->view->templateEmails = $templateEmails = TemplateEmailQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();
        $self = $this;
        $accounts = $this->view->account =    $templateEmails->map(
        function (TemplateEmail $templateEmail) use($self){
            $toAccount = array();

            if ($templateEmail->getToEmployee()==1)
            $toAccount[1]= $self->getI18n()->_('To employee');

            if ($templateEmail->getToGroup()==1)
            $toAccount[3]= $self->getI18n()->_('To group');

            if ($templateEmail->getToUser()==1)
            $toAccount[4]= $self->getI18n()->_('To user');

            return array($templateEmail->getIndex() => implode(", ", $toAccount));
        });
		$this->view->kindOfTickets = $this->getKindOfTicketsCombo();
        $this->view->accounts = $accounts;
        $this->view->status = $this->toFilterSelect(TemplateEmail::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }
	private function getKindOfTicketsCombo(){
		return array('' => $this->i18n->_('All')) + array_flip(TemplateEmail::$KindOfTicket);
	}
    /**
     * @module Template Email
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('template-email', 'create');
        $kindOfTicket = $this->getRequest()->getParam('kind_of_ticket');
        switch ($kindOfTicket){
        	case TemplateEmail::$KindOfTicket['Ticket Empleado']:
        		$events = $this->toFilterSelect(array_flip(EmailEvent::getEvents()));
        		break;
        	case TemplateEmail::$KindOfTicket['Ticket Cliente']:
        		$events = $this->toFilterSelect(array_flip(EmailEvent::getTicketClientEvents()));
        		break;
        	default:
        		$options = EmailEvent::getEvents() + EmailEvent::getTicketClientEvents();
        		$events = $this->toFilterSelect(array_flip($options));
        }
        
		$this->view->kindOfTicket = $kindOfTicket;
        $this->view->languages = array_map(array($this->i18n, "_"), array_flip(Person::$Languages));
        $this->view->events = $events;
        $this->view->actionForm = 'create';
    }

    /**
     * @module Template Email
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TemplateEmail with id {$id}"));
//         $template = TemplateEmailQuery::create()->findByPK($id)->toArray();

//         $events = $this->toFilterSelect(array_flip(EmailEvent::getEvents()));
        switch ($templateEmail->getKindOfTicket()){
        	case TemplateEmail::$KindOfTicket['Ticket Empleado']:
        		$events = $this->toFilterSelect(array_flip(EmailEvent::getEvents()));
        		break;
        	case TemplateEmail::$KindOfTicket['Ticket Cliente']:
        		$events = $this->toFilterSelect(array_flip(EmailEvent::getTicketClientEvents()));
        		break;
        	default:
        		$options = EmailEvent::getEvents() + EmailEvent::getTicketClientEvents();
        		$events = $this->toFilterSelect(array_flip($options));
        }
        $this->view->kindOfTicket = $templateEmail->getKindOfTicket();
        $this->view->languages = array_map(array($this->i18n, "_"), array_flip(Person::$Languages));
        $this->view->events = $events;
        $this->view->template = $templateEmail->toArray();
        
        $this->view->actionForm = 'update/id/'.$id;
        $this->view->setTpl("New");
    }

    /**
     * @module Template Email
     * @action Create
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();
           $errors = $this->validate($params);

            if( count($errors) ){
               $events = $this->toFilterSelect(array_flip(EmailEvent::getEvents()));
               $this->view->events = $events;
               $this->view->setTpl("New");
               $this->view->errors = $errors;
               return;
           }

           try
           {
                  $this->getTemplateEmailCatalog()->beginTransaction();

               $templateEmail = TemplateEmailFactory::createFromArray($params);

               $this->getTemplateEmailCatalog()->create($templateEmail);
               $this->newLogForCreate($templateEmail);

               $this->getTemplateEmailCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Template was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getTemplateEmailCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('template-email/list');
    }

    /**
     * @module Template Email
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
         if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $errors = $this->validate($params);

            if( count($errors) ){
               $events = $this->toFilterSelect(array_flip(EmailEvent::getEvents()));
               $this->view->events = $events;
               $this->view->setTpl("New");
               $this->view->errors = $errors;
               return;
            }


            $id = $this->getRequest()->getParam('id');
            $templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TemplateEmail with id {$id}"));

            try
            {
                $this->getTemplateEmailCatalog()->beginTransaction();

                TemplateEmailFactory::populate($templateEmail,$params);
                $this->getTemplateEmailCatalog()->update($templateEmail);
                $this->newLogForUpdate($templateEmail);

                $this->getTemplateEmailCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Template was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getTemplateEmailCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('template-email/list');
    }

    /**
     * @module Template Email
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TemplateEmail with id {$id}"));

        try
        {
            $this->getTemplateEmailCatalog()->beginTransaction();

            $templateEmail->setStatus(TemplateEmail::$Status['Inactive']);
            $this->getTemplateEmailCatalog()->update($templateEmail);
            $this->newLogForDelete($templateEmail);

            $this->getTemplateEmailCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Template was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getTemplateEmailCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('template-email/list');
    }

    /**
     * @module Template Email
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TemplateEmail with id {$id}"));

        try
        {
            $this->getTemplateEmailCatalog()->beginTransaction();

            $templateEmail->setStatus(TemplateEmail::$Status['Active']);
            $this->getTemplateEmailCatalog()->update($templateEmail);
            $this->newLogForReactivate($templateEmail);

            $this->getTemplateEmailCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Template was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getTemplateEmailCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('template-email/list');
    }

    /**
     * @module Template Email
     * @action Tracking
     */
    protected function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $templateEmail = TemplateEmailQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the TemplateEmail with id {$id}"));
        $this->view->templateEmailLogs = TemplateEmailLogQuery::create()->whereAdd('id_template_email', $id)->find();
        $this->view->users = UserQuery::create()->find()->toCombo();
    }

    /**
     * @param TemplateEmail $templateEmail
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    protected function newLogForCreate(TemplateEmail $templateEmail){
        return $this->newLog($templateEmail, \Application\Model\Bean\TemplateEmailLog::$EventTypes['Create'] );
    }

    /**
     * @param TemplateEmail $templateEmail
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    protected function newLogForUpdate(TemplateEmail $templateEmail){
        return $this->newLog($templateEmail, \Application\Model\Bean\TemplateEmailLog::$EventTypes['Update'] );
    }

    /**
     * @param TemplateEmail $templateEmail
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    protected function newLogForDelete(TemplateEmail $templateEmail){
        return $this->newLog($templateEmail, TemplateEmailLog::$EventTypes['Delete'] );
    }

    /**
     * @param TemplateEmail $templateEmail
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    protected function newLogForReactivate(TemplateEmail $templateEmail){
        return $this->newLog($templateEmail, TemplateEmailLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\TemplateEmailLog
     */
    private function newLog(TemplateEmail $templateEmail, $eventType){
        $now = \Zend_Date::now();
        $log = TemplateEmailLogFactory::createFromArray(array(
            'id_template_email' => $templateEmail->getIdTemplateEmail(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('TemplateEmailLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\TemplateEmailCatalog
     */
    protected function getTemplateEmailCatalog(){
        return $this->getContainer()->get('TemplateEmailCatalog');
    }

    /**
     *
     * @return Application\Form\TemplateEmailForm
     */
    protected function getForm()
    {
        $form = new TemplateEmailForm();
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

    protected function validate($params){
        $errors = array();

        if( empty($params['name']) ){
            $errors['name'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['subject']) ){
            $errors['subject'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['event']) ){
            $errors['event'] = $this->i18n->_("This field is required.");
        }


        return $errors;
    }

}
