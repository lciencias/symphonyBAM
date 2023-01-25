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

use Application\Model\Catalog\EmployeeCatalog;
use Application\Model\Factory\EmployeeFactory;
use Application\Model\Bean\Employee;
use Application\Query\EmployeeQuery;
use Application\Form\EmployeeForm;
use Application\Model\Bean\EmployeeLog;
use Application\Model\Factory\EmployeeLogFactory;
use Application\Model\Catalog\EmployeeLogCatalog;
use Application\Query\EmployeeLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;
use Application\Query\CompanyQuery;
use Application\Model\Bean\Company;
use Application\Query\PositionQuery;
use Application\Model\Bean\Position;
use Application\Query\AreaQuery;
use Application\Model\Bean\Area;
use Application\Query\LocationQuery;
use Application\Model\Bean\Location;
use Application\Model\Bean\PhoneNumber;
use Application\Model\Factory\PhoneNumberFactory;
use Application\Model\Catalog\PhoneNumberCatalog;
use Application\Query\PhoneNumberQuery;
use Application\Model\Bean\Email;
use Application\Model\Factory\EmailFactory;
use Application\Model\Catalog\EmailCatalog;
use Application\Query\EmailQuery;
use Application\Model\Bean;
use Application\Model\Bean\Person;
use Application\Model\Factory;
use Application\Query;



/**
 *
 * @author chente
 */
class EmployeeController extends CrudController
{

    /**
     * @module Employee
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Employee
     * @action List
     * @return array
     */
    public function listAction()
    {
        $page = $this->getRequest()->getParam('page', 1);

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = EmployeeQuery::create()->filter($post)->count();
        $this->view->employees = $employees = EmployeeQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();
        $allOption = array('' => $this->i18n->_('All'));
        $this->view->statuses = $this->toFilterSelect(Employee::$StatusEmployee);
        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->positions = $allOption + \Application\Query\PositionQuery::create()->find()->toCombo();
        $this->view->locations = $allOption + \Application\Query\LocationQuery::create()->find()->toCombo();
        $this->view->companies = $allOption + \Application\Query\CompanyQuery::create()->find()->toCombo();
        $this->view->areas = $allOption + \Application\Query\AreaQuery::create()->find()->toCombo();
    }

    /**
     * @module Employee
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $optionsCompany = CompanyQuery::create()->filter(array(Company::STATUS => Company::$Status['Active']))->find()->toCombo();
        $this->view->languages = array_map(array($this->i18n, "_"), array_flip(Person::$Languages));
        $this->view->companies = $optionsCompany;
        $this->view->phones = array('');
        $this->view->emails = array('');
        $this->view->actionForm = 'create';
        $this->view->setTpl('Edit');
    }

    /**
     * @module Employee
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $employee = EmployeeQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("Not exists the Employee with id {$id}"));
        $companies = CompanyQuery::create()->actives()->find();

        if( !$companies->containsIndex($employee->getIdCompany()) ){
            $companies = $companies->merge(CompanyQuery::create()->pk($employee->getIdCompany())->find());
        }

        $phones = PhoneNumberQuery::create()->innerJoinPerson()
            ->whereAdd('PhoneNumber2Person.id_person',$employee->getIdPerson())
            ->find();

        $emails = EmailQuery::create()->innerJoinPerson()
            ->whereAdd('Email2Person.id_person',$employee->getIdPerson())->find()->toArray();

        $this->view->languages = array_map(array($this->i18n, "_"), array_flip(Person::$Languages));
        $this->view->emails = $emails ?: array(array(''));
        $this->view->companies = $companies->toCombo();
        $this->view->phones = $phones->toArray() ?: array(array(''));
        $this->view->actionForm = 'update/id/'.$employee->getIdEmployee();
        $this->view->employee = $employee->toArray();
        $this->view->post = $employee->toArray();
        $this->view->setTpl("Edit");
    }

    /**
     * @module Employee
     * @action Create
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $errors = $this->validate($params);

           if( count($errors) ){
               $telephons = $this->getRequest()->getParam('id_phone', array());
               $emails = $this->getRequest()->getParam('email', array());

               $optionsCompany = CompanyQuery::create()->filter(array(Company::STATUS => Company::$Status['Active']))->find()->toCombo();
               $this->view->companies = $optionsCompany;
               $this->view->employee = $params;
               $this->view->actionForm = 'create';
               $this->view->setTpl("New");
               $this->view->errors = $errors;
               return;
           }

           try
           {
               $this->getEmployeeCatalog()->beginTransaction();

               $mails = $this->getRequest()->getParam('email', array());
               $employee = EmployeeFactory::createFromArray($params);
               $this->getEmployeeCatalog()->create($employee);
               $arrayPhones = count($this->getRequest()->getParam('id_phone', array()));
               $phonesExt = $this->getRequest()->getParam('phone_ext', array());
               $phones =$this->getRequest()->getParam('id_phone', array());
               $arrayMails = count($this->getRequest()->getParam('email', array()));
               $emails =$this->getRequest()->getParam('email', array());

               if( $arrayPhones > 0 ){

                   foreach ($phones as $i => $phone){
                       if( !empty($phone) ){
                           $phoneNumbers = PhoneNumberFactory::createFromArray(array('number' => $phone, 'extension' => $phonesExt[$i]));
                           $this->getPhoneNumberCatalog()->create($phoneNumbers);
                           $this->getEmployeeCatalog()->linkToPhoneNumber($employee->getIdPerson(), $phoneNumbers->getIdPhoneNumber(), null);
                       }
                   }

               }

               if( $arrayMails > 0 ){

                   foreach ($emails as $email){
                       if( !empty($email) ){
                           $idEmail = EmailFactory::createFromArray(array('email' => $email));

                           $this->getEmailCatalog()->create($idEmail);
                           $this->getEmailCatalog()->linkToPerson($idEmail->getIdEmail(), $employee->getIdPerson(), null);
                       }
                   }

               }

               $this->newLogForCreate($employee);

               $this->getEmployeeCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Employee was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getEmployeeCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('employee/list');
    }

    /**
     * @module Employee
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $employee = EmployeeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Employee with id {$id}"));
        $phones = PhoneNumberQuery::create()->innerJoinPerson()
            ->whereAdd('Person.id_person', $employee->getIdPerson())
            ->find();
        $emails = EmailQuery::create()->innerJoinPerson()
            ->whereAdd('Person.id_person', $employee->getIdPerson())
            ->find();

        if( $this->getRequest()->isPost()){

            $params = $this->getRequest()->getParams();
            $errors = $this->validate($params);

            if( count($errors) ){
                $this->view->emails = $emails;
                $this->view->phones = $phones;
                $optionsCompany = CompanyQuery::create()->filter(array(Company::STATUS => Company::$Status['Active']))->find()->toCombo();
                $this->view->companies = $optionsCompany;
                $this->view->employee = $params;
                $this->view->actionForm = 'update/id/'.$id;
                $this->view->setTpl("Edit");
                $this->view->errors = $errors;

                return;
            }

            try
            {
                $this->getEmployeeCatalog()->beginTransaction();

                $phoneParams = $this->getRequest()->getParam('id_phone', array());
                $emailParams = $this->getRequest()->getParam('email', array());
                $phonesExt = $this->getRequest()->getParam('phone_ext', array());

                EmployeeFactory::populate($employee, $params);
                $this->getEmployeeCatalog()->update($employee);
                $this->newLogForUpdate($employee);


                foreach ($phones as $phone){

                    $this->getPhoneNumberCatalog()->unlinkFromPerson($phone->getIdPhoneNumber(), $employee->getIdPerson());
                    $this->getPhoneNumberCatalog()->deleteById($phone->getIdPhoneNumber());
                }
                foreach($phoneParams as  $i => $phone){
                    if( !empty($phone) ){
                        $phoneNumbers = PhoneNumberFactory::createFromArray(array('number' => $phone, 'extension' => $phonesExt[$i]));

                        $this->getPhoneNumberCatalog()->create($phoneNumbers);
                        $this->getEmployeeCatalog()->linkToPhoneNumber($employee->getIdPerson(), $phoneNumbers->getIdPhoneNumber(), null);
                    }
                }


                foreach ($emails as $email){
                    $this->getEmailCatalog()->unlinkFromPerson($email->getIdEmail(), $employee->getIdPerson());
                    $this->getEmailCatalog()->deleteById($email->getIdEmail());
                }
                foreach ($emailParams as $email){
                    if( !empty($email) ){
                        $contentMail = EmailFactory::createFromArray(array('email' => $email));

                        $this->getEmailCatalog()->create($contentMail);
                        $this->getEmailCatalog()->linkToPerson($contentMail->getIdEmail(), $employee->getIdPerson(), null);
                    }
                }

                $this->getEmployeeCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Employee was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getEmployeeCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('employee/list');
    }

    /**
     *
     */
    public function uploadAction(){

        if( $this->getRequest()->isPost() ){
            $file = new \Application\File\FileUploader('file');
            if( $file->isUpload() ){
                $file->saveFile("/tmp/", false);
                $reader = new \EasyCSV\Reader("/tmp/".$file->getFileName());
                $checker = new \EasyCSV\Checker(array(
                    'name','last_name','middle_name','company','number_1','number_2',
                    'position','area','location','email','email_2','is_vip'
                ));
                $emailRegexp ="/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is";
                $checker->addRequired('name')
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
                            'status_employee' => Employee::$StatusEmployee['Active'],
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
                            $this->getPhoneNumberCatalog()->create($phoneNumber);
                            $this->getPhoneNumberCatalog()->linkToPerson($phoneNumber->getIdPhoneNumber(), $employee->getIdPerson(), null);
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
                            $this->getEmailCatalog()->create($email);
                            $this->getEmailCatalog()->linkToPerson($email->getIdEmail(), $employee->getIdPerson(), null);
                        }

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
     * @module Employee
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $employee = EmployeeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Employee with id {$id}"));

        try
        {
            $this->getEmployeeCatalog()->beginTransaction();

            $employee->setStatusEmployee(Employee::$StatusEmployee['Inactive']);
            $this->getEmployeeCatalog()->update($employee);
            $this->newLogForDelete($employee);

            $this->getEmployeeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Employee was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getEmployeeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('employee/list');
    }

    /**
     * @module Employee
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $employee = EmployeeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Employee with id {$id}"));

        try
        {
            $this->getEmployeeCatalog()->beginTransaction();

            $employee->setStatusEmployee(Employee::$StatusEmployee['Active']);
            $this->getEmployeeCatalog()->update($employee);
            $this->newLogForReactivate($employee);

            $this->getEmployeeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Employee was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getEmployeeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('employee/list');
    }

    /**
     * @module Employee
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $employee = EmployeeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Employee with id {$id}"));
        $this->view->employeeLogs = $logs = EmployeeLogQuery::create()->whereAdd('id_employee', $id)->addDescendingOrderBy(EmployeeLog::DATE_LOG)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     * @param Employee $employee
     * @return \Application\Model\Bean\EmployeeLog
     */
    protected function newLogForCreate(Employee $employee){
        return $this->newLog($employee, \Application\Model\Bean\EmployeeLog::$EventTypes['Create'] );
    }

    /**
     * @param Employee $employee
     * @return \Application\Model\Bean\EmployeeLog
     */
    protected function newLogForUpdate(Employee $employee){
        return $this->newLog($employee, \Application\Model\Bean\EmployeeLog::$EventTypes['Update'] );
    }

    /**
     * @param Employee $employee
     * @return \Application\Model\Bean\EmployeeLog
     */
    protected function newLogForDelete(Employee $employee){
        return $this->newLog($employee, EmployeeLog::$EventTypes['Delete'] );
    }

    /**
     * @param Employee $employee
     * @return \Application\Model\Bean\EmployeeLog
     */
    protected function newLogForReactivate(Employee $employee){
        return $this->newLog($employee, EmployeeLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\EmployeeLog
     */
    private function newLog(Employee $employee, $eventType){
        $now = \Zend_Date::now();
        $log = EmployeeLogFactory::createFromArray(array(
            'id_employee' => $employee->getIdEmployee(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('EmployeeLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\EmployeeCatalog
     */
    protected function getEmployeeCatalog(){
        return $this->getContainer()->get('EmployeeCatalog');
    }

    /**
    * @return \Application\Model\Catalog\PhoneNumberCatalog
    */
    protected function getPhoneNumberCatalog(){
        return $this->getContainer()->get('PhoneNumberCatalog');
    }

    /**
    * @return \Application\Model\Catalog\EmailCatalog
    */
    protected function getEmailCatalog(){
        return $this->getContainer()->get('EmailCatalog');
    }

    /**
     *
     * @return Application\Form\EmployeeForm
     */
    protected function getForm()
    {
        $form = new EmployeeForm();
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

    /**
     *
     * @param unknown_type $params
     */
    protected function validate($params){
        $errors = array();
        $emails = $this->getRequest()->getParam('email', array());
        $countEmails = count($emails);
           if( empty($params['name']) ){
            $errors['name'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['middle_name']) ){
            $errors['middle_name'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['last_name']) ){
            $errors['last_name'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['id_company']) ){
            $errors['last_name'] = $this->i18n->_("This field is required.");
        }

        if( !empty($emails[0])){
            foreach($emails as $i => $email){
                 $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";

                if( !preg_match($regexp, $emails[$i]) ){
                    $errors['email'] = $this->i18n->_("The email is invalid");
                }
            }
        }
        return $errors;
    }

}
