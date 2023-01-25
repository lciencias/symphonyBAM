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

use Application\Model\Catalog\AccessRoleCatalog;
use Application\Model\Factory\AccessRoleFactory;
use Application\Model\Bean\AccessRole;
use Application\Query\AccessRoleQuery;
use Application\Form\AccessRoleForm;
use Application\Model\Bean\AccessRoleLog;
use Application\Model\Factory\AccessRoleLogFactory;
use Application\Model\Catalog\AccessRoleLogCatalog;
use Application\Query\AccessRoleLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class AccessRoleController extends CrudController
{

    /**
     * @module Access Role
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Access Role
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = AccessRoleQuery::create()->filter($post)->count();
        $this->view->accessRoles = $accessRoles = AccessRoleQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->statuses = $this->toFilterSelect(AccessRole::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Access Role
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('access-role', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Access Role
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $accessRole = AccessRoleQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the AccessRole with id {$id}"));

        $url = $this->generateUrl('access-role', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($accessRole->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Access Role
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
               $this->getAccessRoleCatalog()->beginTransaction();

               $accessRole = AccessRoleFactory::createFromArray($form->getValues());
               $accessRole->setStatus(AccessRole::$Status['Active']);
               $this->getAccessRoleCatalog()->create($accessRole);
               $this->newLogForCreate($accessRole);

               $this->getAccessRoleCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("Has been saved successfully"));
           }
           catch(Exception $e)
           {
               $this->getAccessRoleCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('access-role/list');
    }

    /**
     * @module Access Role
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
            $accessRole = AccessRoleQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the AccessRole with id {$id}"));

            try
            {
                $this->getAccessRoleCatalog()->beginTransaction();

                AccessRoleFactory::populate($accessRole, $form->getValues());
                $this->getAccessRoleCatalog()->update($accessRole);
                $this->newLogForUpdate($accessRole);

                $this->getAccessRoleCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("Successfully updated Access Role"));
            }
            catch(Exception $e)
            {
                $this->getAccessRoleCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('access-role/list');
    }

    /**
     * @module Access Role
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $accessRole = AccessRoleQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the AccessRole with id {$id}"));

        try
        {
            $this->getAccessRoleCatalog()->beginTransaction();

            $numUsers = UserQuery::create()
                ->whereAdd('id_access_role', $accessRole->getIdAccessRole())
                ->actives()->count();
            if( $numUsers > 0 ){
                throw new Exception($this->i18n->_("Can not delete the access role because there are active users"));
            }

            $accessRole->setStatus(AccessRole::$Status['Inactive']);
            $this->getAccessRoleCatalog()->update($accessRole);
            $this->newLogForDelete($accessRole);

            $this->getAccessRoleCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("Successfully deactivated Access Role"));
        }
        catch(Exception $e)
        {
            $this->getAccessRoleCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('access-role/list');
    }

    /**
     * @module Access Role
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $accessRole = AccessRoleQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Access Role with id {$id}"));

        try
        {
            $this->getAccessRoleCatalog()->beginTransaction();

            $accessRole->setStatus(AccessRole::$Status['Active']);
            $this->getAccessRoleCatalog()->update($accessRole);
            $this->newLogForReactivate($accessRole);

            $this->getAccessRoleCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("Successfully reactivated Access Role"));
        }
        catch(Exception $e)
        {
            $this->getAccessRoleCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('access-role/list');
    }

    /**
     * @module Access Role
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $accessRole = AccessRoleQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Access Role with id {$id}"));
        $this->view->accessRoleLogs = $logs = AccessRoleLogQuery::create()->whereAdd('id_access_role', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param AccessRole $accessRole
     * @return \Application\Model\Bean\AccessRoleLog
     */
    protected function newLogForCreate(AccessRole $accessRole){
        return $this->newLog($accessRole, \Application\Model\Bean\AccessRoleLog::$EventTypes['Create'] );
    }

    /**
     * @param AccessRole $accessRole
     * @return \Application\Model\Bean\AccessRoleLog
     */
    protected function newLogForUpdate(AccessRole $accessRole){
        return $this->newLog($accessRole, \Application\Model\Bean\AccessRoleLog::$EventTypes['Update'] );
    }

    /**
     * @param AccessRole $accessRole
     * @return \Application\Model\Bean\AccessRoleLog
     */
    protected function newLogForDelete(AccessRole $accessRole){
        return $this->newLog($accessRole, AccessRoleLog::$EventTypes['Delete'] );
    }

    /**
     * @param AccessRole $accessRole
     * @return \Application\Model\Bean\AccessRoleLog
     */
    protected function newLogForReactivate(AccessRole $accessRole){
        return $this->newLog($accessRole, AccessRoleLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\AccessRoleLog
     */
    private function newLog(AccessRole $accessRole, $eventType){
        $now = \Zend_Date::now();
        $log = AccessRoleLogFactory::createFromArray(array(
            'id_access_role' => $accessRole->getIdAccessRole(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('AccessRoleLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\AccessRoleCatalog
     */
    protected function getAccessRoleCatalog(){
        return $this->getContainer()->get('AccessRoleCatalog');
    }

    /**
     *
     * @return Application\Form\AccessRoleForm
     */
    protected function getForm()
    {
        $form = new AccessRoleForm();
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
