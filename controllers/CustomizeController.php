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

use Application\Model\Catalog\CustomizeCatalog;
use Application\Model\Factory\CustomizeFactory;
use Application\Model\Bean\Customize;
use Application\Query\CustomizeQuery;
use Application\Form\CustomizeForm;
use Application\Controller\CrudController;
use Application\Model\Bean\Company;
use Application\Query\CompanyQuery;

/**
 *
 * @author chente
 */
class CustomizeController extends CrudController
{

    /**
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = CustomizeQuery::create()->filter($post)->count();
        $this->view->customizes = $customizes = CustomizeQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->companies = \Application\Query\CompanyQuery::create()->find()->toCombo();
    }

    /**
     * @return array
     */
    public function newAction()
    {
        $optionsCompany = CompanyQuery::create()->filter(array(Company::STATUS => Company::$Status['Active']))->find()->toCombo();
        $companies = array('' => $this->i18n->_('Select') )+ $optionsCompany;
        $this->view->setTpl("New");
        $this->view->companies = $companies;
        $this->view->actionForm = 'create';
    }

    /**
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $customize = CustomizeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Customize with id {$id}"));

        $url = $this->generateUrl('customize', 'update', compact('id'));
        $form = $this->getForm()
            ->populate($customize->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @return array
     */
    public function createAction()
    {

        if( $this->getRequest()->isPost() ){
           $params = $this->getRequest()->getParams();
           $errors = $this->validate($params);

             if( count($errors) ){
               $this->view->setTpl("New");
               $this->view->companies = $companies;
                $this->view->actionForm = 'create';
                $this->view->errors = $errors;
               return;
           }

        }
        $this->_redirect('customize/list');
    }

    /**
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
            $customize = CustomizeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Customize with id {$id}"));

            try
            {
                $this->getCustomizeCatalog()->beginTransaction();

                CustomizeFactory::populate($customize, $form->getValues());
                $this->getCustomizeCatalog()->update($customize);

                $this->getCustomizeCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Customize was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getCustomizeCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('customize/list');
    }

    /**
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $customize = CustomizeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Customize with id {$id}"));

        try
        {
            $this->getCustomizeCatalog()->beginTransaction();

            $this->getCustomizeCatalog()->update($customize);

            $this->getCustomizeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Customize was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getCustomizeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('customize/list');
    }

    /**
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $customize = CustomizeQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Customize with id {$id}"));

        try
        {
            $this->getCustomizeCatalog()->beginTransaction();

            $this->getCustomizeCatalog()->update($customize);

            $this->getCustomizeCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Customize was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getCustomizeCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('customize/list');
    }
    /**
     * @return \Application\Model\Catalog\CustomizeCatalog
     */
    protected function getCustomizeCatalog(){
        return $this->getContainer()->get('CustomizeCatalog');
    }

    /**
     *
     * @return Application\Form\CustomizeForm
     */
    protected function getForm()
    {
        $form = new CustomizeForm();
        $submit = new Zend_Form_Element_Submit("send");
        $submit->setLabel($this->i18n->_("Save"));
        $cancel = new Zend_Form_Element_Button('cancel');
        $cancel->setLabel($this->i18n->_("Cancel"));
        $form->addElement($submit)
            ->addElement($cancel)
            ->setMethod('post');
        $form->setAttrib('enctype', 'multipart/form-data');
      $form->twitterDecorators();
        return $form;
    }

    /**
     *
     * @param array $params
     * @return boolean
     */
    protected function validate($params){
        $errors = array();
        $emails = $this->getRequest()->getParam('email', array());

        if( empty($params['background_color']) ){
            $errors['name'] = $this->i18n->_("This field is required.");
        }

        if( empty($params['background_color']) ){
            $errors['middle_name'] = $this->i18n->_("This field is required.");
        }

        return $errors;
    }

}
