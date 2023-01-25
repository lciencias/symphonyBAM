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

use Application\Model\Catalog\PositionCatalog;
use Application\Model\Factory\PositionFactory;
use Application\Model\Bean\Position;
use Application\Query\PositionQuery;
use Application\Form\PositionForm;
use Application\Model\Bean\PositionLog;
use Application\Model\Factory\PositionLogFactory;
use Application\Model\Catalog\PositionLogCatalog;
use Application\Query\PositionLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class PositionController extends CrudController
{

    /**
     * @module Position
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Position
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = PositionQuery::create()->filter($post)->count();
        $this->view->positions = $positions = PositionQuery::create()
            ->filter($post)
            ->addAscendingOrderBy(Position::NAME)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->companies = array(''=> $this->i18n->_('All')) + \Application\Query\CompanyQuery::create()->find()->toCombo();
        $this->view->statuses = $this->toFilterSelect(Position::$Status);
    }

    /**
     * @module Home
     * @action home
     * @return multitype:multitype:number string
     */
    public function jsonAction()
    {
        $id = $this->getRequest()->getParam('id');
        $extraId = $this->getRequest()->getParam('selected_id');

        $positions = PositionQuery::create()
            ->filter(array(Position::ID_COMPANY => $id))
            ->actives()
            ->find();

        if( $extraId ){
            $positions = $positions->merge(PositionQuery::create()->pk($extraId)->find());
        }

        $positions = $positions->map(function(Position $position){
            return array($position->getIdPosition() => array(
                'id' => $position->getIdPosition(),
                'position' => utf8_encode($position->getName()),
            ));
        });

        die(json_encode(array_values($positions)));
    }

    /**
     * @module Position
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('position', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Position
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $position = PositionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Position with id {$id}"));

        $url = $this->generateUrl('position', 'update', compact('id'));
        $form = $this->getForm($position)
            ->populate($position->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Position
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
               $this->getPositionCatalog()->beginTransaction();

               $position = PositionFactory::createFromArray($form->getValues());
               $this->getPositionCatalog()->create($position);
               $this->newLogForCreate($position);

               $this->getPositionCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Position was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getPositionCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('position/list');
    }

    /**
     * @module Position
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $position = PositionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Position with id {$id}"));

        $form = $this->getForm($position);
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            try
            {
                $this->getPositionCatalog()->beginTransaction();

                PositionFactory::populate($position, $form->getValues());
                $this->getPositionCatalog()->update($position);
                $this->newLogForUpdate($position);

                $this->getPositionCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Position was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getPositionCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('position/list');
    }

    /**
     * @module Position
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $position = PositionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Position with id {$id}"));

        try
        {
            $this->getPositionCatalog()->beginTransaction();

            $position->setStatus(Position::$Status['Inactive']);
            $this->getPositionCatalog()->update($position);
            $this->newLogForDelete($position);

            $this->getPositionCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Position was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getPositionCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('position/list');
    }

    /**
     * @module Position
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $position = PositionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Position with id {$id}"));

        try
        {
            $this->getPositionCatalog()->beginTransaction();

            $position->setStatus(Position::$Status['Active']);
            $this->getPositionCatalog()->update($position);
            $this->newLogForReactivate($position);

            $this->getPositionCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Position was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getPositionCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('position/list');
    }

    /**
     * @module Position
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $position = PositionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Position with id {$id}"));
        $this->view->positionLogs = $logs = PositionLogQuery::create()->whereAdd('id_position', $id)->addDescendingOrderBy(PositionLog::DATE_LOG)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Position $position
     * @return \Application\Model\Bean\PositionLog
     */
    protected function newLogForCreate(Position $position){
        return $this->newLog($position, \Application\Model\Bean\PositionLog::$EventTypes['Create'] );
    }

    /**
     * @param Position $position
     * @return \Application\Model\Bean\PositionLog
     */
    protected function newLogForUpdate(Position $position){
        return $this->newLog($position, \Application\Model\Bean\PositionLog::$EventTypes['Update'] );
    }

    /**
     * @param Position $position
     * @return \Application\Model\Bean\PositionLog
     */
    protected function newLogForDelete(Position $position){
        return $this->newLog($position, PositionLog::$EventTypes['Delete'] );
    }

    /**
     * @param Position $position
     * @return \Application\Model\Bean\PositionLog
     */
    protected function newLogForReactivate(Position $position){
        return $this->newLog($position, PositionLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\PositionLog
     */
    private function newLog(Position $position, $eventType){
        $now = \Zend_Date::now();
        $log = PositionLogFactory::createFromArray(array(
            'id_position' => $position->getIdPosition(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('PositionLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\PositionCatalog
     */
    protected function getPositionCatalog(){
        return $this->getContainer()->get('PositionCatalog');
    }

    /**
     *
     * @return Application\Form\PositionForm
     */
    protected function getForm(Position $position = null)
    {
        $form = new PositionForm(array('position' => $position));
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
