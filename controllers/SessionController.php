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

use Application\Model\Catalog\SessionCatalog;
use Application\Model\Factory\SessionFactory;
use Application\Model\Bean\Session;
use Application\Query\SessionQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class SessionController extends CrudController
{

    /**
     * @module Session
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Session
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = SessionQuery::create()->filter($post)->count();
        $this->view->sessions = $sessions = SessionQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();
        $this->view->users = UserQuery::create()->pk($sessions->getUserIds())->find()->toCombo();
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     *
     * @return array
     */
    public function newAction(){}

    /**
     *
     * @return array
     */
    public function editAction(){}

    /**
     *
     * @return array
     */
    public function createAction(){}

    /**
     *
     * @return array
     */
    public function updateAction(){}

    /**
     * @module Session
     * @action Destroy
     */
    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        $session = SessionQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Session with id {$id}"));

        try
        {
            $this->getSessionCatalog()->deleteById($session->getIdSession());

            $this->setFlash('ok', $this->i18n->_("The Session was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('session/list');
    }

    /**
     * @return Catalog
     */
    private function getSessionCatalog(){
        return $this->getCatalog('SessionCatalog');
    }

}
