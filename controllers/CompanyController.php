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

use Application\Model\Catalog\CompanyCatalog;
use Application\Model\Factory\CompanyFactory;
use Application\Model\Bean\Company;
use Application\Query\CompanyQuery;
use Application\Form\CompanyForm;
use Application\Model\Bean\CompanyLog;
use Application\Model\Factory\CompanyLogFactory;
use Application\Model\Catalog\CompanyLogCatalog;
use Application\Query\CompanyLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class CompanyController extends CrudController
{

    /**
     * @module Company
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Company
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = CompanyQuery::create()->filter($post)->count();
        $this->view->companies = $companies = CompanyQuery::create()
            ->filter($post)
            ->addAscendingOrderBy(Company::NAME)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->statuses = $this->toFilterSelect(Company::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Company
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('company', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Company
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $company = $this->findByID($id);

        $url = $this->generateUrl('company', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($company->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Company
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
               $this->getCompanyCatalog()->beginTransaction();

               $company = CompanyFactory::createFromArray($form->getValues());
               $company->setStatus(Company::$Status['Active']);
               $this->getCompanyCatalog()->create($company);
               $this->newLogForCreate($company);

               $this->getCompanyCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Company was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getCompanyCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('company/list');
    }

    /**
     * @module Company
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
            $company = $this->findByID($id);

            try
            {
                $this->getCompanyCatalog()->beginTransaction();

                CompanyFactory::populate($company, $form->getValues());
                $this->getCompanyCatalog()->update($company);
                $this->newLogForUpdate($company);

                $this->getCompanyCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Company was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getCompanyCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('company/list');
    }

    /**
     * @module Company
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $company = $this->findByID($id);

        try
        {
            $this->getCompanyCatalog()->beginTransaction();

            $company->setStatus(Company::$Status['Inactive']);
            $this->getCompanyCatalog()->update($company);
            $this->newLogForDelete($company);

            $this->getCompanyCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Company was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getCompanyCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('company/list');
    }

    /**
     * @module Company
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $company = $this->findByID($id);

        try
        {
            $this->getCompanyCatalog()->beginTransaction();

            $company->setStatus(Company::$Status['Active']);
            $this->getCompanyCatalog()->update($company);
            $this->newLogForReactivate($company);

            $this->getCompanyCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Company was successfully activated"));
        }
        catch(Exception $e)
        {
            $this->getCompanyCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('company/list');
    }

    /**
     * @module Company
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $company = $this->findByID($id);
        $this->view->companyLogs = $logs = CompanyLogQuery::create()->whereAdd('id_company', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     *
     * @param int $id
     * @return \Application\Model\Bean\Company
     */
    private function findByID($id){
        return CompanyQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("The Company with id not exists, id:"). $id);
    }

    /**
     * @param Company $company
     * @return \Application\Model\Bean\CompanyLog
     */
    protected function newLogForCreate(Company $company){
        return $this->newLog($company, \Application\Model\Bean\CompanyLog::$EventTypes['Create'] );
    }

    /**
     * @param Company $company
     * @return \Application\Model\Bean\CompanyLog
     */
    protected function newLogForUpdate(Company $company){
        return $this->newLog($company, \Application\Model\Bean\CompanyLog::$EventTypes['Update'] );
    }

    /**
     * @param Company $company
     * @return \Application\Model\Bean\CompanyLog
     */
    protected function newLogForDelete(Company $company){
        return $this->newLog($company, CompanyLog::$EventTypes['Delete'] );
    }

    /**
     * @param Company $company
     * @return \Application\Model\Bean\CompanyLog
     */
    protected function newLogForReactivate(Company $company){
        return $this->newLog($company, CompanyLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\CompanyLog
     */
    private function newLog(Company $company, $eventType){
        $now = \Zend_Date::now();
        $log = CompanyLogFactory::createFromArray(array(
            'id_company' => $company->getIdCompany(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('CompanyLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\CompanyCatalog
     */
    protected function getCompanyCatalog(){
        return $this->getContainer()->get('CompanyCatalog');
    }

    /**
     *
     * @return Application\Form\CompanyForm
     */
    protected function getForm()
    {
        $form = new CompanyForm();
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
