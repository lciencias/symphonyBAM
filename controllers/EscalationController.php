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

use Application\Model\Catalog\EscalationCatalog;
use Application\Model\Factory\EscalationFactory;
use Application\Model\Bean\EscalationDetail;
use Application\Model\Catalog\EscalationDetailCatalog;
use Application\Model\Factory\EscalationDetailFactory;
use Application\Model\Bean\Escalation;
use Application\Model\Bean\Employee;
use Application\Query\EscalationQuery;
use Application\Query\EscalationDetailQuery;
use Application\Query\EmployeeQuery;
use Application\Model\Bean\EscalationLog;
use Application\Model\Factory\EscalationLogFactory;
use Application\Model\Catalog\EscalationLogCatalog;
use Application\Query\EscalationLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;

/**
 *
 * @author chente
 */
class EscalationController extends CrudController
{

    /**
     * @module Escalation
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Escalation
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = EscalationQuery::create()->filter($post)->count();
        $this->view->escalations = $escalations = EscalationQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->statuses = $this->toFilterSelect(Escalation::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Escalation
     * @action Create
     * @return array
     */
    public function newAction()
    {
        $this->view->actionForm = 'create';
        $this->view->details = array('');
        $this->view->types = EscalationDetail::$TypesLabels;
    }

    /**
     * @module Escalation
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $escalation = EscalationQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Escalation with id {$id}"));
        $details = EscalationDetailQuery::create()
            ->filter(array(EscalationDetail::ID_ESCALATION => $escalation->getIdEscalation()))
            ->find();
        $self = $this;

        $detailsArray= array();
        while( $details->valid() ) {
            $detail = $details->read();
            $element = $detail->toArray();
            if( $detail->isEmployeeType() ){
                $employee = EmployeeQuery::create()->findByPKOrThrow($detail->getValue(), $self->getI18n()->_("Not exists the Escalation with id {$id}"));
                $element['autocomplete'] = $employee->getFullName();
            }
            $detailsArray[] = $element;
        }

        $this->view->actionForm = 'update/id/'.$escalation->getIdEscalation();
        $this->view->details = $detailsArray;
        $this->view->escalation = $escalation->toArray();
        $this->view->types = EscalationDetail::$TypesLabels;
        $this->view->setTpl("New");
    }

    /**
     * @module Escalation
     * @action Create
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){

           $percentages = $this->getRequest()->getParam('percentage', array());
           $types = $this->getRequest()->getParam('type', array());
           $values = $this->getRequest()->getParam('value', array());
           $params = $this->getRequest()->getParams();
           $errors = $this->validate($params);
           if( count($errors) ){
               $autocompletes = $this->getRequest()->getParam('autocomplete', array());
               $details = array();
               foreach($types as $i => $type){
                   $details[] = array(
                       'type' => $type,
                       'percentage' => $percentages[$i],
                       'autocomplete' => $autocompletes[$i],
                       'value' => $values[$i],
                   );
               }
               $this->view->escalation = $params;
               $this->view->actionForm = 'create';
               $this->view->types = EscalationDetail::$TypesLabels;
               $this->view->details = $details;
               $this->view->setTpl("New");
               $this->view->errors = $errors;
               return;
           }

           try
           {
               $this->getEscalationCatalog()->beginTransaction();

               $escalation = EscalationFactory::createFromArray($params);
               $escalation->setStatus(Escalation::$Status['Active']);
               $this->getEscalationCatalog()->create($escalation);
               $this->newLogForCreate($escalation);

               foreach($types as $i => $type){
                   $detail = EscalationDetailFactory::createFromArray(array(
                       'id_escalation' => $escalation->getIdEscalation(),
                       'percentage' => $percentages[$i],
                       'type' => $type,
                       'value' => $values[$i],
                   ));
                   $this->getCatalog('EscalationDetailCatalog')->create($detail);
               }

               $this->getEscalationCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Escalation was created correctly"));
           }
           catch(Exception $e)
           {
               $this->getEscalationCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('escalation/list');
    }

    /**
     * @module Escalation
     * @action Edit
     * @return array
     */
    public function updateAction()
    {
        if( $this->getRequest()->isPost() ){

            $params = $this->getRequest()->getParams();
            $percentages = $this->getRequest()->getParam('percentage', array());
            $types = $this->getRequest()->getParam('type', array());
            $values = $this->getRequest()->getParam('value', array());
            $id = $this->getRequest()->getParam('id');
            $escalation = EscalationQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Escalation with id {$id}"));

            $errors = $this->validate($params);
            if( count($errors) ){
                $autocompletes = $this->getRequest()->getParam('autocomplete', array());
                $details = array();
                foreach($types as $i => $type){
                    $details[$i] = array(
                        'type' => $type,
                        'percentage' => $percentages[$i],
                        'autocomplete' => $autocompletes[$i],
                        'value' => $values[$i],
                    );
                }
                $this->view->escalation = $escalation->toArray();
                $this->view->types = EscalationDetail::$TypesLabels;
                $this->view->details = $details;
                $this->view->setTpl("New");
                $this->view->errors = $errors;
                $this->view->actionForm = 'update/id/'.$id;
                return;
            }

            try
            {
                $this->getEscalationCatalog()->beginTransaction();

                EscalationFactory::populate($escalation, $params);
                $this->getEscalationCatalog()->update($escalation);
                $this->newLogForUpdate($escalation);

                $this->getEscalationDetailCatalog()->deleteByIdEscalation($escalation->getIdEscalation());
                foreach($types as $i => $type){
                    $detail = EscalationDetailFactory::createFromArray(array(
                        'id_escalation' => $escalation->getIdEscalation(),
                        'percentage' => $percentages[$i],
                        'type' => $type,
                        'value' => $values[$i],
                    ));
                    $this->getCatalog('EscalationDetailCatalog')->create($detail);
                }

                $this->getEscalationCatalog()->commit();
                $this->setFlash('ok', $this->i18n->_("The Escalation was updated correctly"));
            }
            catch(Exception $e)
            {
                $this->getEscalationCatalog()->rollBack();
                $this->setFlash('error', $this->i18n->_($e->getMessage()));
            }
        }
        $this->_redirect('escalation/list');
    }

    /**
     * @module Escalation
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $escalation = EscalationQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Escalation with id {$id}"));

        try
        {
            $this->getEscalationCatalog()->beginTransaction();

            $escalation->setStatus(Escalation::$Status['Inactive']);
            $this->getEscalationCatalog()->update($escalation);
            $this->newLogForDelete($escalation);

            $this->getEscalationCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Escalation was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getEscalationCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('escalation/list');
    }

    /**
     * @module Escalation
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $escalation = EscalationQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Escalation with id {$id}"));

        try
        {
            $this->getEscalationCatalog()->beginTransaction();

            $escalation->setStatus(Escalation::$Status['Active']);
            $this->getEscalationCatalog()->update($escalation);
            $this->newLogForReactivate($escalation);

            $this->getEscalationCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Escalation was successfully reactivated"));
        }
        catch(Exception $e)
        {
            $this->getEscalationCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('escalation/list');
    }

    /**
     * @module Home
     * @action home
     */
    public function getEmployeesAction(){
        $term = $this->getRequest()->getParam('term');
        $employees = EmployeeQuery::create()->where()
            ->setOR()
                ->add(Employee::NAME, $term, EmployeeQuery::LIKE)
                ->add(Employee::MIDDLE_NAME, $term, EmployeeQuery::LIKE)
                ->add(Employee::LAST_NAME, $term, EmployeeQuery::LIKE)
            ->endWhere()
            ->find()
            ->map(function (Employee $employee){
                return array(array(
                    'label' => utf8_encode($employee->getFullName()),
                    'value' => $employee->getIdEmployee(),
                ));
            });
        die(json_encode($employees));
    }

    /**
     * @module Escalation
     * @action Tracking
     */
    protected function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $escalation = EscalationQuery::create()->findByPKOrThrow($id, $this->i18n->_("Not exists the Escalation with id {$id}"));
        $this->view->escalationLogs = $logs = EscalationLogQuery::create()->whereAdd('id_escalation', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }


    /**
     *
     * @param unknown_type $params
     * @return array
     */
    protected function validate($params){
        $errors = array();
        $percentages = $this->getRequest()->getParam('percentage', array());
        $types = $this->getRequest()->getParam('type', array());
        $values = $this->getRequest()->getParam('value', array());

        if( empty($params['name']) ){
            $errors['name'] = $this->i18n->_("The Escalation name is invalid");
        }

        foreach ($types as $i => $type){
            if( empty($type) || empty($percentages[$i]) || empty($values[$i]) ){
                $errors[$i][] = $this->i18n->_("All fields must be filled");
                continue;
            }

            if( $type == EscalationDetail::$Types['Employee'] ){
                $employee = EmployeeQuery::create()->findByPK($values[$i]);
                if( !($employee instanceof Employee) ){
                    $errors[$i][] = $this->i18n->_("The employee not exists");
                }
            }

            if( $type == EscalationDetail::$Types['Email'] ){
                $regexp="/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i";
                if( !preg_match($regexp, $values[$i]) ){
                    $errors[$i][] = $this->i18n->_("The email is invalid");
                }
            }

        }

        return $errors;
    }

    /**
     * @param Escalation $escalation
     * @return \Application\Model\Bean\EscalationLog
     */
    protected function newLogForCreate(Escalation $escalation){
        return $this->newLog($escalation, \Application\Model\Bean\EscalationLog::$EventTypes['Create'] );
    }

    /**
     * @param Escalation $escalation
     * @return \Application\Model\Bean\EscalationLog
     */
    protected function newLogForUpdate(Escalation $escalation){
        return $this->newLog($escalation, \Application\Model\Bean\EscalationLog::$EventTypes['Update'] );
    }

    /**
     * @param Escalation $escalation
     * @return \Application\Model\Bean\EscalationLog
     */
    protected function newLogForDelete(Escalation $escalation){
        return $this->newLog($escalation, EscalationLog::$EventTypes['Delete'] );
    }

    /**
     * @param Escalation $escalation
     * @return \Application\Model\Bean\EscalationLog
     */
    protected function newLogForReactivate(Escalation $escalation){
        return $this->newLog($escalation, EscalationLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\EscalationLog
     */
    private function newLog(Escalation $escalation, $eventType){
        $now = \Zend_Date::now();
        $log = EscalationLogFactory::createFromArray(array(
            'id_escalation' => $escalation->getIdEscalation(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('EscalationLogCatalog')->create($log);
        return $log;
    }

    /**
     * @return \Application\Model\Catalog\EscalationCatalog
     */
    protected function getEscalationCatalog(){
        return $this->getCatalog('EscalationCatalog');
    }

    /**
     * @return \Application\Model\Catalog\EscalationDetailCatalog
     */
    protected function getEscalationDetailCatalog(){
        return $this->getCatalog('EscalationDetailCatalog');
    }

}
