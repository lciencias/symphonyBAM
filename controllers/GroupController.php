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

use Application\Model\Bean\Employee;

use Application\Query\EmployeeQuery;

use Application\Model\Bean\User;

use Application\Query\WorkweekQuery;

use Application\Model\Catalog\GroupCatalog;
use Application\Model\Factory\GroupFactory;
use Application\Model\Bean\Group;
use Application\Query\GroupQuery;
use Application\Form\GroupForm;
use Application\Model\Bean\GroupLog;
use Application\Model\Factory\GroupLogFactory;
use Application\Model\Catalog\GroupLogCatalog;
use Application\Query\GroupLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class GroupController extends CrudController
{

    /**
     * @module Group
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Group
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = GroupQuery::create()->filter($post)->count();
        $this->view->groups = $groups = GroupQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $allOption = array(''=> $this->i18n->_('All'));
        $users = $this->view->users = $allOption + \Application\Query\UserQuery::create()->find()->fullName();
        $this->view->workweeks = $allOption + \Application\Query\WorkweekQuery::create()->find()->toCombo();
        $this->view->statuses = $this->toFilterSelect(Group::$Status);
    }

    /**
     * @module Group
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('group', 'create');
        $this->view->users = UserQuery::create()->actives()->find()->toCombo();
        $this->view->workweeks = WorkweekQuery::create()->actives()->find()->toCombo();
        $group = new Group();
        $group->setStatus(Group::$Status['Active']);
        $this->view->group = $group;
        $this->view->onsumbit = 'create';
        
//         $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Group
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $group = GroupQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Group with id {$id}"));
        $this->view->users = UserQuery::create()->actives()->find()->toCombo();
        $this->view->workweeks = WorkweekQuery::create()->actives()->find()->toCombo();
        $users = GroupQuery::create()
        ->innerJoinUser()
        ->whereAdd("Group.".Group::ID_GROUP, $group->getIdGroup())
        ->addColumn('User.id_user')
        ->fetchAll();
        $groupUsers = UserQuery::create()->whereAdd('User.'.User::ID_USER, $users)
        ->actives()
        ->find();
        $this->view->groupUsers = $groupUsers;
        $this->view->group = $group;
        $this->view->onsumbit = 'update';
        $this->view->setTpl("New");
    }

    /**
     * @module Group
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
               $this->getGroupCatalog()->beginTransaction();

               $group = GroupFactory::createFromArray($form->getValues());
               $this->getGroupCatalog()->create($group);
               $this->newLogForCreate($group);

               $this->getGroupCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Group was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getGroupCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('group/list');
    }

    /**
     * @module Group
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $group = GroupQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Group with id {$id}"));

        $form = $this->getForm($group);
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            try
            {
                $this->getGroupCatalog()->beginTransaction();

                GroupFactory::populate($group, $params);
                $this->getGroupCatalog()->update($group);
                $this->newLogForUpdate($group);

                $this->getGroupCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Group was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getGroupCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('group/list');
    }

    /**
     * @module Group
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $group = GroupQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Group with id {$id}"));

        try
        {
            $this->getGroupCatalog()->beginTransaction();

            $group->setStatus(Group::$Status['Inactive']);
            $this->getGroupCatalog()->update($group);
            $this->newLogForDelete($group);

            $this->getGroupCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Group was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getGroupCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('group/list');
    }

    /**
     * @module Group
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $group = GroupQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Group with id {$id}"));

        try
        {
            $this->getGroupCatalog()->beginTransaction();

            $group->setStatus(Group::$Status['Active']);
            $this->getGroupCatalog()->update($group);
            $this->newLogForReactivate($group);

            $this->getGroupCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Group was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getGroupCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('group/list');
    }

    /**
     * @module Group
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $group = GroupQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Group with id {$id}"));
        $this->view->groupLogs = $logs = GroupLogQuery::create()->whereAdd('id_group', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Group $group
     * @return \Application\Model\Bean\GroupLog
     */
    protected function newLogForCreate(Group $group){
        return $this->newLog($group, \Application\Model\Bean\GroupLog::$EventTypes['Create'] );
    }

    /**
     * @param Group $group
     * @return \Application\Model\Bean\GroupLog
     */
    protected function newLogForUpdate(Group $group){
        return $this->newLog($group, \Application\Model\Bean\GroupLog::$EventTypes['Update'] );
    }

    /**
     * @param Group $group
     * @return \Application\Model\Bean\GroupLog
     */
    protected function newLogForDelete(Group $group){
        return $this->newLog($group, GroupLog::$EventTypes['Delete'] );
    }

    /**
     * @param Group $group
     * @return \Application\Model\Bean\GroupLog
     */
    protected function newLogForReactivate(Group $group){
        return $this->newLog($group, GroupLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\GroupLog
     */
    private function newLog(Group $group, $eventType){
        $now = \Zend_Date::now();
        $log = GroupLogFactory::createFromArray(array(
            'id_group' => $group->getIdGroup(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('GroupLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\GroupCatalog
     */
    protected function getGroupCatalog(){
        return $this->getContainer()->get('GroupCatalog');
    }

    /**
     *
     * @return Application\Form\GroupForm
     */
    protected function getForm(Group $group = null)
    {
        $form = new GroupForm(array('group' => $group));
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
