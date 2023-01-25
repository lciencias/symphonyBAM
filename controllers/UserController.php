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

use Application\Query\EmployeeQuery;

use Application\Query\AccessRoleQuery;

use Application\Model\Catalog\UserCatalog;
use Application\Model\Factory\UserFactory;
use Application\Model\Factory;
use Application\Model\Bean\User;
use Application\Model\Bean;
use Application\Query\UserQuery;
use Application\Form\UserForm;
use Application\Form\EditUserForm;
use Application\Model\Bean\UserLog;
use Application\Model\Bean\Group;
use Application\Model\Bean\Employee;
use Application\Model\Factory\UserLogFactory;
use Application\Model\Catalog\UserLogCatalog;
use Application\Query\UserLogQuery;
use Application\Query\GroupQuery;
use Application\Query;
use Application\Controller\CrudController;
use Application\Query\BranchQuery;
use Application\Query\ChannelQuery;

/**
 *
 * @author chente
 */
class UserController extends CrudController
{

    /**
     * @module User
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module User
     * @action List
     * @return array
     */
    public function listAction()
    {
        $page = $this->getRequest()->getParam('page', 1);

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = UserQuery::create()->filter($post)->count();
        $this->view->users = $users = UserQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $self = $this;
        $userLog =  $this->view->userLog = $users->map(function( User $user ) use($self){
            $log = UserLogQuery::create()
                ->select(UserLog::TIMESTAMP)
                ->filter(array(
                      UserLog::EVENT_TYPE => UserLog::LOGIN,
                      UserLog::ID_USER => $user->getIdUser(),
                 ))
                ->addDescendingOrderBy(UserLog::TIMESTAMP)
                ->setLimit(1)
            ->fetchOne();

            if( !$log ){
                $log = $self->getI18n()->_("No records");
            }

            return array($user->getIdUser() => $log);
        });

        $groups = $this->view->groups =    $users->map(
        function (User $user){
            $groups = GroupQuery::create()
            ->innerJoinUser()->whereAdd("User.id_user", $user->getIdUser())
            ->find()->toCombo();
            return array($user->getIdUser() => implode(", ", $groups));
        });

        $allOption = array('' => $this->i18n->_('All'));
        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->accessRoles =  $allOption + \Application\Query\AccessRoleQuery::create()->find()->toCombo();
        $this->view->statuses =  $allOption + User::$StatusCombo;
        $this->view->statuses = $this->toFilterSelect(User::$Status);
    }

    /**
     * @module User
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $this->view->form      = $this->getForm()->setAction($url);
        $this->view->accessRoles = AccessRoleQuery::create()->actives()->find()->toCombo();
        $this->view->groups    = GroupQuery::create()->actives()->find()->toCombo();
        $this->view->employees = EmployeeQuery::create()->actives()->find()->toCombo();
        $this->view->branches  = $this->toFilterSelectCombo(BranchQuery::create()->actives()->find()->toCombo());
        $this->view->channels  = $this->toFilterSelectCombo(ChannelQuery::create()->actives()->find()->toCombo());
        $this->view->onsubmit  = 'create';
    }

    /**
     * @module User
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $user = UserQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the User with id {$id}"));
        $userGroups = GroupQuery::create()
            ->innerJoinUser()->whereAdd("User.id_user", $user->getIdUser())
            ->find()->getPrimaryKeys();
        $form = $this->getEditForm($user)
            ->populate(array_merge($user->toArray(), array('group' => $groups)))
            ->setAction($url);
		$this->view->accessRoles = AccessRoleQuery::create()->find()->toCombo();
		$this->view->groups = GroupQuery::create()->actives()->find()->toCombo();
		//die("user:  ".$user->getIdEmployee());
		$employees = EmployeeQuery::create();
		if((int) $user->getIdEmployee() > 0){
			$employees = $employees->whereAdd(Employee::ID_EMPLOYEE, $user->getIdEmployee());
		}
		$employees = $employees->find()->toCombo();
		$this->view->employees = $employees;
		$this->view->branches  = $this->toFilterSelectCombo(BranchQuery::create()->actives()->find()->toCombo());
		$this->view->channels  = $this->toFilterSelectCombo(ChannelQuery::create()->actives()->find()->toCombo());		
		$this->view->user = $user->toArray();
		$this->view->userGroups = $userGroups;
        $this->view->form = $form;
        $this->view->onsubmit = 'update';
        $this->view->setTpl("New");
    }
    
    /**
     * @module User
     * @action Edit Password
     */
	public function editPasswordAction(){
		$id = $this->getRequest()->getParam('id');
		try {
			$user = UserQuery::create()->findByPK($id);
		}catch(Exception $e){
			$this->setFlash('error',$this->i18n->_("Not exists the User with id {$id}"));
			$this->_redirect('user/list');
		}
		$this->view->user = $user->toArray();
	}
	/**
	 * @module User
	 * @action Edit Password
	 */
	public function updatePasswordAction(){
			$id = $this->getRequest()->getParam('id');
			$user = UserQuery::create()->findByPK($id);
			$password = sha1($this->getRequest()->getParam('password'));
			$user->setPassword($password);
			$this->getUserCatalog()->beginTransaction();
			try {
				if ($this->validatePassword($password, $id)){
					$this->getUserCatalog()->update($user);
					$this->newLogForChangePasssword($user);
					$this->setFlash('ok', $this->i18n->_("The User was updated correctly"));
					$this->getUserCatalog()->commit();
				}else {
					$this->getUserCatalog()->rollBack();
					$this->setFlash('error', $this->i18n->_('The password cannot be repeated yet'));
					$this->_redirect('user/edit-password/id/'.$id);
				}
			}catch(Exception $e){
				$this->getUserCatalog()->rollBack();
				$this->setFlash('error', $this->i18n->_($e->getMessage()));
			} 
			$this->_redirect('user/edit-password/id/'.$id);
	}
    /**
     * @module User
     * @action Create
     * @return array
     */
    public function createAction()
    {
        $form = $this->getForm();
           try
           {
           	   $id_branch = $id_channel = null;
               $this->getUserCatalog()->beginTransaction();
               $employee = $this->getRequest()->getParam('id_employee');
               if( (int) $this->getRequest()->getParam('id_branch') > 0){
               		$id_branch = $this->getRequest()->getParam('id_branch');
               }
               if( (int) $this->getRequest()->getParam('id_channel') > 0){
               		$id_channel = $this->getRequest()->getParam('id_channel');
               }
               $accessRole = $this->getRequest()->getParam('id_access_role');
               $username = $this->getRequest()->getParam('username');
               $pass = ($this->getRequest()->getParam('password'));
               $status = $this->getRequest()->getParam('status');
               $userParams = array(
                    'id_access_role' => $accessRole,
                    'id_employee' => $employee,
               		'id_branch'   => $id_branch,
               		'id_channel'   => $id_channel,               
                    'username' => $username,
                    'password' =>sha1($pass),
                    'status' => $status
               );

               $user = UserFactory::createFromArray($userParams);
               $this->getUserCatalog()->create($user);

               $groups = $this->getRequest()->getParam('group', array());
               $this->getUserCatalog()->unlinkAllGroup($user->getIdUser());
               foreach ($groups as $idGroup){
                   $this->getUserCatalog()->linkToGroup($user->getIdUser(), $idGroup);
               }

               $this->getUserCatalog()->commit();
               $this->newLogForCreate($user);
               $this->setFlash('ok', $this->i18n->_("The User was created correctly"));

           }
           catch(Exception $e)
           {
               $this->getUserCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        $this->_redirect('user/list');
    }

    /**
     * @module User
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $user = UserQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the User with id {$id}"));
        $employee = $this->getRequest()->getParam('id_employee');
        $form = $this->getEditForm($user);
        if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();
            $isSamePassword = $params['password'] == $params['password_confirm'];
            //if( !$form->isValid($params) || !$isSamePassword ){
            if(!$isSamePassword ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                if( !$isSamePassword ){
                    $this->view->error = $this->i18n->_("The passwords do not match");
                }
                return;
            }
            try
            {
                $this->getUserCatalog()->beginTransaction();
                $id_branch = $id_channel = null;                
                if( (int) $this->getRequest()->getParam('id_branch') > 0){
               		$id_branch = $this->getRequest()->getParam('id_branch');
                }
                if( (int) $this->getRequest()->getParam('id_channel') > 0){
               		$id_channel = $this->getRequest()->getParam('id_channel');
                }                 
                $accessRole = $this->getRequest()->getParam('id_access_role');
                $username = $this->getRequest()->getParam('username');
                $pass = ($this->getRequest()->getParam('password'));
                $status = $this->getRequest()->getParam('status');                
                $userParams = array(
                    'id_access_role' => $accessRole,
                    'id_employee'    => $employee,
                	'id_branch'      => $id_branch,
                	'id_channel'     => $id_channel,                		
                    'username' 		 => $username,
                    'status' 		 => $status
                );

                if( $pass ){
                    $userParams['password'] = sha1($pass);
                    if (!$this->validatePassword($userParams['password'], $user->getIdUser())){
                    	$this->setFlash('error', $this->i18n->_('The password cannot be repeated yet.'));
                    	$this->_redirect('user/edit/id/'.$id);
                    }                    
                }
                UserFactory::populate($user, $userParams);
                $this->getUserCatalog()->update($user);
                $user = UserQuery::create()->findByPK($id);
                if( $pass ){
                	$this->newLogForChangePasssword($user);
                }
                $this->newLogForUpdate($user);

                $groups = $this->getRequest()->getParam('group', array());
                $this->getUserCatalog()->unlinkAllGroup($user->getIdUser());
                foreach ($groups as $idGroup){
                    $this->getUserCatalog()->linkToGroup($user->getIdUser(), $idGroup);
                }
                
                if( (int) $this->getRequest()->getParam('id_branch') == 0){                	
                	$upda = "update pcs_common_users set id_branch = null where id_employee = '".$employee."'";
					$this->getUserCatalog()->getDb()->query($upda);
                }
                if( (int) $this->getRequest()->getParam('id_channel') == 0){
                	$upda = "update pcs_common_users set id_channel = null where id_employee = '".$employee."'";
					$this->getUserCatalog()->getDb()->query($upda);
                	
                }
                $this->getUserCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The User was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getUserCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('user/list');
    }
    /**
     * 
     * @param string $password
     * @param int $idUser
     * @return bool
     */
	private function validatePassword($password,$idUser){
		$userLogs = UserLogQuery::create()
		->whereAdd(UserLog::ID_USER, $idUser)
		->whereAdd(UserLog::EVENT_TYPE, UserLog::CHANGE_PASSWORD)
		->orderBy(UserLog::ID_USER_LOG, UserLogQuery::DESC)
		->setLimit(UserLog::PASSWORD_REPEAT_TIMES)
		->find();
		
		$flag = true;
		while ($userLog = $userLogs->read()){
			$flag = $password == $userLog->getNote() ? false : true;
			if(!$flag) break;
		}
		return $flag;
	}
    /**
     * @module User
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $user = UserQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the User with id {$id}"));

        try
        {
            $this->getUserCatalog()->beginTransaction();

            $user->setStatus(User::$Status['Inactive']);
            $this->getUserCatalog()->update($user);
            $this->newLogForDelete($user);

            $this->getUserCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The User was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getUserCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('user/list');
    }

    /**
     * @module User
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $user = UserQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the User with id {$id}"));

        try
        {
            $this->getUserCatalog()->beginTransaction();

            $user->setStatus(User::$Status['Active']);
            $this->getUserCatalog()->update($user);
            $this->newLogForReactive($user);

            $this->getUserCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The User was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getUserCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('user/list');
    }

    /**
     *
     */
    public function uploadAction(){

        if( $this->getRequest()->isPost() ){
            $file = new \Application\File\FileUploader('file');
            if( $file->isUpload() ){
                $workweek = Query\WorkweekQuery::create()->findOneOrThrow("No se ha definido ningun horario");
                $file->saveFile("/tmp/", false);
                $reader = new \EasyCSV\Reader("/tmp/".$file->getFileName());
                $checker = new \EasyCSV\Checker(array(
                        "username", "password", "role", "group",
                        'name','last_name','middle_name','company','number_1','number_2',
                        'position','area','location','email','email_2','is_vip',
                ));
                $emailRegexp ="/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is";
                $checker
                ->addRequired('username')
                ->addRequired('password')
                ->addRequired('role')
                ->addRequired('group')
                ->addRequired('name')
                ->addRequired('company')
                ->addRequired('position')
                ->addRequired('area')
                ->addRequired('location')
                ->addRule('email', $emailRegexp, "The email is invalid", false)
                ->addRule('email_2', $emailRegexp, "The email is invalid", false)
                ->addRule('is_vip', "/^(0|1){1}$/", "0 or 1 for the field is_vip", false)
                ;
                try {
                    $checker->check($reader);
                } catch (\EasyCSV\ValidationException $e) {
                    $this->view->errors = $e->getErrors();
                    return ;
                }

                try
                {
                    $this->getCatalog('EmployeeCatalog')->beginTransaction();

                    foreach ($reader as $line => $row) {

                        $row = array_map('trim', $row);
                        $company = Query\CompanyQuery::create()
                        ->notCache()
                        ->filter(array('name' => $row['company']))->findOne();
                        if( !$company ){
                            $company = Factory\CompanyFactory::createFromArray(array(
                                    'name' => $row['company'],
                                    'status' => Bean\Company::$Status['Active'],
                            ));
                            $this->getCatalog('CompanyCatalog')->create($company);
                        }

                        $position = Query\PositionQuery::create()
                        ->notCache()
                        ->filter(array('id_company' => $company->getIdCompany(), 'name' => $row['position']))
                        ->findOne();
                        if( !$position ){
                            $position = Factory\PositionFactory::createFromArray(array(
                                    'name' => $row['position'],
                                    'id_company' => $company->getIdCompany(),
                                    'status' => Bean\Position::$Status['Active'],
                            ));
                            $this->getCatalog('PositionCatalog')->create($position);
                        }

                        $area = Query\AreaQuery::create()
                        ->notCache()
                        ->filter(array('id_company' => $company->getIdCompany(), 'name' => $row['area']))
                        ->findOne();
                        if( !$area ){
                            $area = Factory\AreaFactory::createFromArray(array(
                                    'name' => $row['area'],
                                    'id_company' => $company->getIdCompany(),
                                    'status' => Bean\Area::$Status['Active'],
                            ));
                            $this->getCatalog('AreaCatalog')->create($area);
                        }

                        $location = Query\LocationQuery::create()
                        ->notCache()
                        ->filter(array('id_company' => $company->getIdCompany(), 'name' => $row['location']))
                        ->findOne();
                        if( !$location ){
                            $location = Factory\LocationFactory::createFromArray(array(
                                    'name' => $row['location'],
                                    'id_company' => $company->getIdCompany(),
                                    'status' => Bean\Location::$Status['Active'],
                            ));
                            $this->getCatalog('LocationCatalog')->create($location);
                        }

                        $employee = Factory\EmployeeFactory::createFromArray(array(
                                'name' => $row['name'],
                                'last_name' => $row['last_name'],
                                'middle_name' => $row['middle_name'],
                                'id_position' => $position->getIdPosition(),
                                'id_location' => $location->getIdLocation(),
                                'id_area' => $area->getIdArea(),
                                'id_company' => $company->getIdCompany(),
                                'is_vip' => (boolean) $row['is_vip'],
                                'status_employee' => Bean\Employee::$StatusEmployee['Active'],
                        ));
                        $this->getCatalog('EmployeeCatalog')->create($employee);

                        $phoneNumbers = array();
                        if( !empty($row['number_1']) ){
                            $phoneNumbers[] = Factory\PhoneNumberFactory::createFromArray(array(
                                    'number' => $row['number_1'],
                            ));
                        }
                        if( !empty($row['number_2']) ){
                            $phoneNumbers[] = Factory\PhoneNumberFactory::createFromArray(array(
                                    'number' => $row['number_2'],
                            ));
                        }
                        foreach( $phoneNumbers as $phoneNumber ){
                            $this->getCatalog('PhoneNumberCatalog')->create($phoneNumber);
                            $this->getCatalog('PhoneNumberCatalog')->linkToPerson($phoneNumber->getIdPhoneNumber(), $employee->getIdPerson(), null);
                        }

                        $emails = array();
                        if( !empty($row['email']) ){
                            $emails[] = Factory\EmailFactory::createFromArray(array(
                                    'email' => $row['email'],
                            ));
                        }
                        if( !empty($row['email_2']) ){
                            $emails[] = Factory\EmailFactory::createFromArray(array(
                                    'email' => $row['email_2'],
                            ));
                        }
                        foreach( $emails as $email ){
                            $this->getCatalog('EmailCatalog')->create($email);
                            $this->getCatalog('EmailCatalog')->linkToPerson($email->getIdEmail(), $employee->getIdPerson(), null);
                        }

                        $role = Query\AccessRoleQuery::create()
                        ->notCache()
                        ->filter(array('name' => $row['role']))
                        ->findOne();
                        if( !$role ){
                            $role = Factory\AccessRoleFactory::createFromArray(array(
                                    'name' => $row['role'],
                                    'status' => Bean\AccessRole::$Status['Active'],
                            ));
                            $this->getCatalog('AccessRoleCatalog')->create($role);
                        }

                        $group = Query\GroupQuery::create()
                        ->notCache()
                        ->filter(array('name' => $row['group']))
                        ->findOne();
                        if( !$group ){
                            $group = Factory\GroupFactory::createFromArray(array(
                                    'name' => $row['group'],
                                    'id_user' => $this->getUser()->getIdUser(),
                                    'id_workweek' => $workweek->getIdWorkweek(),
                                    'status' => Bean\Area::$Status['Active'],
                            ));
                            $this->getCatalog('GroupCatalog')->create($group);
                        }

                        $userParams = array(
                                'id_access_role' => $role->getIdAccessRole(),
                                'id_employee' => $employee->getIdEmployee(),
                                'username' => $row['username'],
                                'password' => new Zend_Db_Expr("PASSWORD('{$row['password']}')"),
                                'status' => Bean\User::$Status['Active'],
                                );

                        $user = UserFactory::createFromArray($userParams);
                        $this->getUserCatalog()->create($user);

                        $this->getUserCatalog()->linkToGroup($user->getIdUser(), $group->getIdGroup());

                    }

                    $this->getCatalog('EmployeeCatalog')->commit();
                }
                catch (\Exception $e) {
                    $this->getCatalog('EmployeeCatalog')->rollBack();
                    throw $e;
                }

            }
        }
    }

    /**
     * @module User
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $user = UserQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the User with id {$id}"));
        $this->view->userLogs = $logs = UserLogQuery::create()->whereAdd('id_user', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserResponsibleIds())->find()->toCombo();
    }

    /**
     * @param User $user
     * @return \Application\Model\Bean\UserLog
     */
    protected function newLogForCreate(User $user){
        return $this->newLog($user, UserLog::CREATE);
    }

    /**
     * @param User $user
     * @return \Application\Model\Bean\UserLog
     */
    protected function newLogForUpdate(User $user){
        return $this->newLog($user, UserLog::EDIT);
    }

    /**
     * @param User $user
     * @return \Application\Model\Bean\UserLog
     */
    protected function newLogForDelete(User $user){
        return $this->newLog($user, UserLog::DEACTIVATE);
    }

    /**
    * @param User $user
    * @return \Application\Model\Bean\UserLog
    */
    protected function newLogForReactive(User $user){
        return $this->newLog($user, UserLog::REACTIVATE);
    }
    /**
     * @param User $user
     * @return \Application\Model\Bean\UserLog
     */
    protected function newLogForChangePasssword(User $user){
    	return $this->newLog($user, UserLog::CHANGE_PASSWORD);
    }
    /**
     *
     * @param User $user
     * @param int $eventType
     * @return \Application\Model\Bean\UserLog
     */
    protected function newLog(User $user, $eventType){
    	$date = new Zend_Date();
    	$events = array_flip(UserLog::$EventTypeName);
    	$note = $events[$eventType];
    	$note = $eventType == UserLog::CHANGE_PASSWORD ? $user->getPassword() : $note;
    	$log = \Application\Model\Factory\UserLogFactory::createFromArray(array(
    			'id_user' => $user->getIdUser(),
    			'event_type' => $eventType,
    			'ip' => $this->getRequest()->getServer("REMOTE_ADDR"),
    			'id_responsible' => $this->getUser()->getBean()->getIdUser(),
    			'timestamp' => $date->get('yyyy-MM-dd HH:mm:ss'),
    			'note' => $note,
        ));
        $this->getCatalog('UserLogCatalog')->create($log);
        return $log;
    }

    /**
     * @return \Application\Model\Catalog\UserCatalog
     */
    protected function getUserCatalog(){
        return $this->getContainer()->get('UserCatalog');
    }

    /**
     *
     * @return Application\Form\UserForm
     */
    protected function getForm()
    {
        $form = new UserForm();
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

    protected function getEditForm(User $user)
    {
        $form = new EditUserForm(array('user' => $user));
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
