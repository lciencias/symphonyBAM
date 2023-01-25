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

use Application\Model\Catalog\ChannelCatalog;
use Application\Model\Factory\ChannelFactory;
use Application\Model\Bean\Channel;
use Application\Query\ChannelQuery;
use Application\Form\ChannelForm;
use Application\Model\Bean\ChannelLog;
use Application\Model\Factory\ChannelLogFactory;
use Application\Model\Catalog\ChannelLogCatalog;
use Application\Query\ChannelLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class ChannelController extends CrudController
{

    /**
     *
     * @module Channel
     * @action List
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     *
     * @module Channel
     * @action List
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = ChannelQuery::create()->filter($post)->count();
        $this->view->channels = $channels = ChannelQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(Channel::$Status);
    }

    /**
     *
     * @module Channel
     * @action Create
     */
    public function newAction()
    {
        $url = $this->generateUrl('channel', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     *
     * @module Channel
     * @action Edit
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $channel = ChannelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Channel with id {$id}"));

        $url = $this->generateUrl('channel', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($channel->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     *
     * @module Channel
     * @action Create
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
               $this->getChannelCatalog()->beginTransaction();

               $channel = ChannelFactory::createFromArray($form->getValues());
               $this->getChannelCatalog()->create($channel);
               $this->newLogForCreate($channel);

               $this->getChannelCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Channel was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getChannelCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('channel/list');
    }

    /**
     *
     * @module Channel
     * @action Edit
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
            $channel = ChannelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Channel with id {$id}"));

            try
            {
                $this->getChannelCatalog()->beginTransaction();

                ChannelFactory::populate($channel, $form->getValues());
                $this->getChannelCatalog()->update($channel);
                $this->newLogForUpdate($channel);

                $this->getChannelCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Channel was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getChannelCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('channel/list');
    }

    /**
     * @module Channel
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $channel = ChannelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Channel with id {$id}"));

        try
        {
            $this->getChannelCatalog()->beginTransaction();

            $channel->setStatus(Channel::$Status['Inactive']);
            $this->getChannelCatalog()->update($channel);
            $this->newLogForDelete($channel);

            $this->getChannelCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Channel was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getChannelCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('channel/list');
    }

    /**
     * @module Channel
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $channel = ChannelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Channel with id {$id}"));

        try
        {
            $this->getChannelCatalog()->beginTransaction();

            $channel->setStatus(Channel::$Status['Active']);
            $this->getChannelCatalog()->update($channel);
            $this->newLogForReactivate($channel);

            $this->getChannelCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Channel was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getChannelCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('channel/list');
    }

    /**
     * @module Channel
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $channel = ChannelQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Channel with id {$id}"));
        $this->view->channelLogs = $logs = ChannelLogQuery::create()->whereAdd('id_channel', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Channel $channel
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function newLogForCreate(Channel $channel){
        return $this->newLog($channel, \Application\Model\Bean\ChannelLog::$EventTypes['Create'] );
    }

    /**
     * @param Channel $channel
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function newLogForUpdate(Channel $channel){
        return $this->newLog($channel, \Application\Model\Bean\ChannelLog::$EventTypes['Update'] );
    }

    /**
     * @param Channel $channel
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function newLogForDelete(Channel $channel){
        return $this->newLog($channel, ChannelLog::$EventTypes['Delete'] );
    }

    /**
     * @param Channel $channel
     * @return \Application\Model\Bean\ChannelLog
     */
    protected function newLogForReactivate(Channel $channel){
        return $this->newLog($channel, ChannelLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\ChannelLog
     */
    private function newLog(Channel $channel, $eventType){
        $now = \Zend_Date::now();
        $log = ChannelLogFactory::createFromArray(array(
            'id_channel' => $channel->getIdChannel(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('ChannelLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getChannelCatalog(){
        return $this->getContainer()->get('ChannelCatalog');
    }

    /**
     *
     * @return Application\Form\ChannelForm
     */
    protected function getForm()
    {
        $form = new ChannelForm();
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
