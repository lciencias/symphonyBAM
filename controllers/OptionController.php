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

use Application\Model\Catalog\OptionCatalog;
use Application\Model\Factory\OptionFactory;
use Application\Model\Bean\Option;
use Application\Query\OptionQuery;
use Application\Form\OptionForm;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class OptionController extends CrudController
{

    /**
     * @module Parameters
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Parameters
     * @action List
     * @return array
     */
    public function listAction()
    {
        $page = $this->getRequest()->getParam('page', 1);

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = OptionQuery::create()->filter($post)->count();
        $options = OptionQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->getOptionService()->wrappperCollection($options);
        $this->view->options = $options;
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     *
     */
    public function newAction()
    {
    }

    /**
     * @module Parameters
     * @action Edit
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $this->view->option = $this->getOptionService()->getById($id);
    }

    /**
     *
     */
    public function createAction()
    {
    }

    /**
     * @module Parameters
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();

            $id = $this->getRequest()->getParam('idOption');
            $option = $this->getOptionService()->getById($id);

            try
            {
                $this->getOptionCatalog()->beginTransaction();

                $this->getOptionService()->update($option, $this->getRequest()->getParam('value'));

                $this->getOptionCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The parameter was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getOptionCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('option/list');
    }

    /**
     *
     */
    public function deleteAction(){
    }
    /**
     * @return \Application\Model\Catalog\OptionCatalog
     */
    protected function getOptionCatalog(){
        return $this->getContainer()->get('OptionCatalog');
    }

    /**
     * @return \Application\Service\OptionService
     */
    protected function getOptionService(){
        return $this->getContainer()->get('OptionService');
    }


}
