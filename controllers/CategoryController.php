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

use Application\Model\Catalog\CategoryCatalog;
use Application\Model\Factory\CategoryFactory;
use Application\Model\Factory\CategoryLogFactory;
use Application\Model\Bean\Category;
use Application\Model\Bean\CategoryLog;
use Application\Query\CategoryQuery;
use Application\Query\CategoryLogQuery;
use Application\Query\UserQuery;
use Application\Query;
use Application\Query\CompanyQuery;
use Application\Form\CategoryForm;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class CategoryController extends CrudController
{

    /**
     * @module Category
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Category
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->companies = CompanyQuery::create()->actives()->find()->toCombo();
        $idCompany = $this->getRequest()->getParam('id_company', false);
        if( !$idCompany ){
            return ;
        }
        $company = CompanyQuery::create()
            ->findByPKOrThrow($idCompany, $this->i18n->_("Not exists the company with id: "). $idCompany);

        $categories = CategoryQuery::create()
//             ->actives()
            ->whereAdd(Category::ID_COMPANY, $company->getIdCompany())
            ->addAscendingOrderBy(Category::NAME)
            ->find();
        $this->view->company = $company;
        $this->view->nestedCategories =  $categories->filterRoot()->toNestedArray($categories);
    }

    /**
     * @module Category
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $form = $this->getForm();
        $idParent = $this->getRequest()->getParam('idParent', null);
        $idCompany = $this->getRequest()->getParam('id_company', null);
        if( null != $idParent ){
            $form->setIdParent($idParent);
        }
        if( null != $idCompany ){
            $form->setIdCompany($idCompany);
        }
        $url = $this->generateUrl('category', 'create');
        $this->view->form = $form->setAction($url);
    }

    /**
     * @module Category
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $category = $this->findByID($id);

        $url = $this->generateUrl('category', 'update', compact('id'));
        $form = $this->getForm(array('category' => $category))
            ->populate($category->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Category
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
               $this->getCategoryCatalog()->beginTransaction();

               $category = $this->createCategory($form->getValues());

               $this->getCategoryCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Category was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getCategoryCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('category/list/id_company/'.$params['id_company']);
    }

    /**
     *
     * @throws Exception
     */
    public function uploadAction()
    {
        if( $this->getRequest()->isPost() )
        {
            $file = new \Application\File\FileUploader('file');
            if( $file->isUpload() )
            {
                $file->saveFile("/tmp/", false);
                $reader = new \EasyCSV\Reader("/tmp/".$file->getFileName());
                $checker = new \EasyCSV\Checker(array(
                    "number","company","name","parent_number","escalation","group","service_level","note"
                ));
                $checker->addRequired('number')
                    ->addRequired('company')
                    ->addRequired('escalation')
                    ->addRequired('group')
                    ->addRequired('service_level')
                ;
                try {
                    $checker->check($reader);
                } catch (\EasyCSV\ValidationException $e) {
                    $this->view->errors = $e->getErrors();
                    return ;
                }

                $categoryCatalog = $this->getCatalog('CategoryCatalog');
                try
                {
                    $categoryCatalog->beginTransaction();

                    $categories = array();
                    foreach ($reader as $line => $row) {
                        $row = array_map('trim', $row);

                        $company = Query\CompanyQuery::create()->filter(array('name' => $row['company']))->findOneOrThrow("La empresa no existe");
                        $escalation = Query\EscalationQuery::create()->filter(array('name' => $row['escalation']))->findOneOrThrow("El escalamiento no existe");
                        $group = Query\GroupQuery::create()->filter(array('name' => $row['group']))->findOneOrThrow("El grupo no existe");
                        $serviceLevel = Query\ServiceLevelQuery::create()->filter(array('name' => $row['service_level']))->findOneOrThrow("El nivel de servicio no existe");

                        $category = $this->createCategory(array(
                            'id_company' => $company->getIdCompany(),
                            'id_escalation' => $escalation->getIdEscalation(),
                            'id_group' => $group->getIdGroup(),
                            'id_parent' => isset($categories[$row['parent_number']]) ? $categories[$row['parent_number']] : null,
                            'id_service_level' => $serviceLevel->getIdServiceLevel(),
                            'name' => $row['name'],
                            'note' => $row['note'],
                        ));
                        $categories[$row['number']] = $category->getIdCategory();
                    }

                    $categoryCatalog->commit();
                }
                catch (\Exception $e) {
                    $categoryCatalog->rollBack();
                    throw $e;
                }

            }
        }
    }

    /**
     * @module Category
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $category = $this->findByID($id);

        $form = $this->getForm(array('category' => $category));
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            try
            {
                $this->getCategoryCatalog()->beginTransaction();

                CategoryFactory::populate($category, $form->getValues());
                $this->getCategoryCatalog()->update($category);
                $this->newLogForUpdate($category);

                $this->getCategoryCatalog()->commit();

                $this->setFlash('ok', $this->i18n->_("The Category was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getCategoryCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('category/list/id_company/'.$params['id_company']);
    }

    /**
     * @module Category
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $category = $this->findByID($id);

        try
        {
            $this->getCategoryCatalog()->beginTransaction();

            $category->setStatus(Category::$Status['Inactive']);
            $this->getCategoryCatalog()->update($category);
            $this->newLogForDelete($category);

            $this->getCategoryCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Category was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getCategoryCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('category/list/id_company/'.$category->getIdCompany());
    }

    /**
     * @module Category
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $category = $this->findByID($id);

        try
        {
            $this->getCategoryCatalog()->beginTransaction();

            $category->setStatus(Category::$Status['Active']);
            $this->getCategoryCatalog()->update($category);
            $this->newLogForReactivate($category);

            $this->getCategoryCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Category was successfully activated"));
        }
        catch(Exception $e)
        {
            $this->getCategoryCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('category/list/id_company/'.$category->getIdCompany());
    }

    /**
     * @module Category
     * @action Tracking
     */
    protected function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $category = $this->findByID($id);
        $this->view->categoryLogs = CategoryLogQuery::create()->whereAdd('id_category', $id)->find();
        $this->view->users = UserQuery::create()->find()->toCombo();
    }

    /**
     *
     * @param array $params
     * @return Category
     */
    protected function createCategory($params)
    {
        $category = CategoryFactory::createFromArray($params);
        $category->setStatus(Category::$Status['Active']);
        $category->setIsLeaf(true);

        if( $category->getIdParent() ){
            $parentCategory = $this->findByID($category->getIdParent());
            $parentCategory->setIsLeaf(false);
            $this->getCategoryCatalog()->update($parentCategory);
        }

        $this->getCategoryCatalog()->create($category);
        $this->newLogForCreate($category);

        return $category;
    }

    /**
     * @param Category $category
     * @return \Application\Model\Bean\CategoryLog
     */
    protected function newLogForCreate(Category $category){
        return $this->newLog($category, \Application\Model\Bean\CategoryLog::$EventTypes['Create'] );
    }

    /**
     * @param Category $category
     * @return \Application\Model\Bean\CategoryLog
     */
    protected function newLogForUpdate(Category $category){
        return $this->newLog($category, \Application\Model\Bean\CategoryLog::$EventTypes['Update'] );
    }

    /**
     * @param Category $category
     * @return \Application\Model\Bean\CategoryLog
     */
    protected function newLogForDelete(Category $category){
        return $this->newLog($category, CategoryLog::$EventTypes['Delete'] );
    }

    /**
     * @param Category $category
     * @return \Application\Model\Bean\CategoryLog
     */
    protected function newLogForReactivate(Category $category){
        return $this->newLog($category, CategoryLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\CategoryLog
     */
    private function newLog(Category $category, $eventType){
        $now = \Zend_Date::now();
        $log = CategoryLogFactory::createFromArray(array(
            'id_category' => $category->getIdCategory(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('CategoryLogCatalog')->create($log);
        return $log;
    }

    /**
     *
     * @param int $id
     * @return Category
     */
    private function findByID($id){
        return CategoryQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("Not exists the Category with id: ").$id);
    }

    /**
     * @return \Application\Model\Catalog\CategoryCatalog
     */
    protected function getCategoryCatalog(){
        return $this->getContainer()->get('CategoryCatalog');
    }

    /**
     * @return \Application\Service\CategoryService
     */
    protected function getCategoryService(){
        return $this->getContainer()->get('CategoryService');
    }

    /**
     * @param array $options
     * @return Application\Form\CategoryForm
     */
    protected function getForm($options = array())
    {
        $form = new CategoryForm($options);
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
