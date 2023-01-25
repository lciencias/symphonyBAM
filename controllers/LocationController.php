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

use Application\Model\Catalog\LocationCatalog;
use Application\Model\Factory\LocationFactory;
use Application\Model\Bean\Location;
use Application\Query\LocationQuery;
use Application\Form\LocationForm;
use Application\Model\Bean\LocationLog;
use Application\Model\Factory\LocationLogFactory;
use Application\Model\Catalog\LocationLogCatalog;
use Application\Query\LocationLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class LocationController extends CrudController
{

    /**
     * @module Location
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Location
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = LocationQuery::create()->filter($post)->count();
        $this->view->locations = $locations = LocationQuery::create()
            ->filter($post)
            ->addAscendingOrderBy(Location::NAME)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->paginator = $this->createPaginator($total, $page);
        $this->view->statuses = $this->toFilterSelect(Location::$Status);
        $this->view->companies = array('' => $this->i18n->_('All')) + \Application\Query\CompanyQuery::create()->find()->toCombo();
    }

    /**
     * @module Home
     * @action home
     */
    public function jsonAction()
    {
        $id = $this->getRequest()->getParam('id');
        $firstOption = $this->getRequest()->getParam('firstOption');
        $extraId = $this->getRequest()->getParam('selected_id');

        $locations = LocationQuery::create()
            ->filter(array(Location::ID_COMPANY => $id))
            ->actives()
            ->find();

        if( $extraId ){
            $locations = $locations->merge(LocationQuery::create()->pk($extraId)->find());
        }

        $locations = $locations->map(function (Location $location){
            return array($location->getIdLocation() => array(
                'id' => $location->getIdLocation(),
                'location' => utf8_encode($location->getName()),
            ));
        });

        if( $firstOption ){
            $locations = array( -1 => array(
                    'id' => '',
                    'location' => $this->i18n->_("All"),
                )
            ) + $locations;
        }
        die(json_encode(array_values($locations)));
    }

    /**
     * @module Location
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $url = $this->generateUrl('location', 'create');
        $this->view->form = $this->getForm()->setAction($url);
    }

    /**
     * @module Location
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $location = $this->findByID($id);

        $url = $this->generateUrl('location', 'update', compact('id'));
        $form = $this->getForm($location)
            ->populate($location->toArray())
            ->setAction($url);

        $this->view->form = $form;
        $this->view->setTpl("New");
    }

    /**
     * @module Location
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
               $this->getLocationCatalog()->beginTransaction();

               $location = LocationFactory::createFromArray($form->getValues());
               $location->setStatus(Location::$Status['Active']);
               $this->getLocationCatalog()->create($location);
               $this->newLogForCreate($location);

               $this->getLocationCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Location was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getLocationCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('location/list');
    }

    /**
     * @module Location
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        $location = $this->findByID($id);

        $form = $this->getForm($location);
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            if( !$form->isValid($params) ){
                $this->view->setTpl("New");
                $this->view->form = $form;
                return;
            }

            try
            {
                $this->getLocationCatalog()->beginTransaction();

                LocationFactory::populate($location, $form->getValues());
                $this->getLocationCatalog()->update($location);
                $this->newLogForUpdate($location);

                $this->getLocationCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Location was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getLocationCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('location/list');
    }

    /**
     * @module Location
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $location = $this->findByID($id);

        try
        {
            $this->getLocationCatalog()->beginTransaction();

            $location->setStatus(Location::$Status['Inactive']);
            $this->getLocationCatalog()->update($location);
            $this->newLogForDelete($location);

            $this->getLocationCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Location was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getLocationCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('location/list');
    }

    /**
     * @module Location
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $location = $this->findByID($id);

        try
        {
            $this->getLocationCatalog()->beginTransaction();

            $location->setStatus(Location::$Status['Active']);
            $this->getLocationCatalog()->update($location);
            $this->newLogForReactivate($location);

            $this->getLocationCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Location was successfully activated"));
        }
        catch(Exception $e)
        {
            $this->getLocationCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('location/list');
    }

    /**
     * @module Location
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $location = $this->findByID($id);
        $this->view->locationLogs = $logs = LocationLogQuery::create()->whereAdd('id_location', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     *
     * @param unknown_type $id
     * @return Location
     */
    private function findByID($id){
        return LocationQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("Not exists the Location with id: ") . $id);
    }

    /**
     * @param Location $location
     * @return \Application\Model\Bean\LocationLog
     */
    protected function newLogForCreate(Location $location){
        return $this->newLog($location, \Application\Model\Bean\LocationLog::$EventTypes['Create'] );
    }

    /**
     * @param Location $location
     * @return \Application\Model\Bean\LocationLog
     */
    protected function newLogForUpdate(Location $location){
        return $this->newLog($location, \Application\Model\Bean\LocationLog::$EventTypes['Update'] );
    }

    /**
     * @param Location $location
     * @return \Application\Model\Bean\LocationLog
     */
    protected function newLogForDelete(Location $location){
        return $this->newLog($location, LocationLog::$EventTypes['Delete'] );
    }

    /**
     * @param Location $location
     * @return \Application\Model\Bean\LocationLog
     */
    protected function newLogForReactivate(Location $location){
        return $this->newLog($location, LocationLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\LocationLog
     */
    private function newLog(Location $location, $eventType){
        $now = \Zend_Date::now();
        $log = LocationLogFactory::createFromArray(array(
            'id_location' => $location->getIdLocation(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('LocationLogCatalog')->create($log);
        return $log;
    }
    /**
     * @return \Application\Model\Catalog\LocationCatalog
     */
    protected function getLocationCatalog(){
        return $this->getContainer()->get('LocationCatalog');
    }

    /**
     *
     * @return Application\Form\LocationForm
     */
    protected function getForm(Location $location = null)
    {
        $form = new LocationForm(array('location' => $location));
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
