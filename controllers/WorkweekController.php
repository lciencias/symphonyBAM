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

use Application\Model\Catalog\WorkweekCatalog;
use Application\Model\Factory\WorkweekFactory;
use Application\Model\Factory\WorkdayFactory;
use Application\Model\Bean\Workweek;
use Application\Query\WorkweekQuery;
use Application\Query\WorkdayQuery;
use Application\Model\Bean\WorkweekLog;
use Application\Model\Factory\WorkweekLogFactory;
use Application\Model\Catalog\WorkweekLogCatalog;
use Application\Query\WorkweekLogQuery;
use Application\Query\UserQuery;
use Application\Controller\CrudController;
use Application\Model\Bean\Workday;

/**
 *
 * @author chente
 */
class WorkweekController extends CrudController
{

    /**
     * @module Schedule
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Schedule
     * @action List
     * @return array
     */
    public function listAction()
    {
        $this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;

        if( $this->getRequest()->isPost() ){
            $this->view->post = $post = $this->getRequest()->getParams();
        }

        $total = WorkweekQuery::create()->filter($post)->count();
        $this->view->workweeks = $workweeks = WorkweekQuery::create()
            ->filter($post)
            ->page($page, $this->getMaxPerPage())
            ->find();

        $this->view->statuses = $this->toFilterSelect(Workweek::$Status);
        $this->view->paginator = $this->createPaginator($total, $page);
    }

    /**
     * @module Schedule
     * @action Create
     * @return array
     */
    public function newAction()
    {
       $this->assignCombos();
    }

    /**
     * @module Schedule
     * @action Edit
     * @return array
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $workweek = $this->findByID($id);
        $workdays = WorkdayQuery::create()->whereAdd('id_workweek', $workweek->getIdWorkweek())->find();

        $this->assignCombos();
        $this->view->workdays = $workdays->toEditArray();
        $this->view->workweek = $workweek->toArray();
        $this->view->setTpl("New");
    }

    /**
     * @module Schedule
     * @action Create
     * @return array
     */
    public function createAction()
    {
        if( $this->getRequest()->isPost() ){

           $params = $this->getRequest()->getParams();
           $enableDays = array_keys($this->getRequest()->getParam('enableDays', array()));
           $idWorkweek = $this->getRequest()->getParam('id_workweek', -1);
           $startTime = $this->getRequest()->getParam('start_time', array());
           $lunchStartTime = $this->getRequest()->getParam('lunch_start_time', array());
           $lunchEndTime = $this->getRequest()->getParam('lunch_end_time', array());
           $endTime = $this->getRequest()->getParam('end_time', array());

           $errors = $this->validate($params);
           if( count($errors) ){
               $this->view->setTpl("New");
               $this->view->errors = $errors;
               $this->view->post = $params;
               $this->assignCombos();
               return;
           }

           try
           {
               $this->getWorkweekCatalog()->beginTransaction();

               if( count($startTime) == 0 ){
                   throw new Exception($this->i18n->_("The scheduled cannot be empty"));
               }

               $workweek = WorkweekQuery::create()->findByPKOrElse($idWorkweek, new Workweek());
               WorkweekFactory::populate($workweek, $params);
               if( $workweek->getIdWorkweek() ){
                   $this->getWorkweekCatalog()->update($workweek);
                   $this->newLogForUpdate($workweek);
               }else{
                   $workweek->setStatus(Workweek::$Status['Active']);
                   $this->getWorkweekCatalog()->create($workweek);
                   $this->newLogForCreate($workweek);
               }
               $this->getWorkdayCatalog()->deleteByIdWorkweek($workweek->getIdWorkweek());

               foreach(WorkDay::$Days as $day)
               {
                   if( in_array($day, $enableDays) ){
                       $workday = WorkdayFactory::createFromArray(array(
                           'id_workweek' => $workweek->getIdWorkweek(),
                           'day_of_week' => $day,
                           'start_time' => $startTime[$day],
                           'lunch_start_time' => $lunchStartTime[$day],
                           'lunch_end_time' => $lunchEndTime[$day],
                           'end_time' => $endTime[$day],
                       ));
                       if( empty($startTime[$day]) && empty($lunchStartTime[$day]) && empty($lunchEndTime[$day]) && empty($endTime[$day]) ){
                           throw new Exception($this->i18n->_("Invalid data"));
                       }
                       $this->getWorkdayCatalog()->create($workday);
                   }
               }

               $this->getWorkweekCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("The Schedule was saved correctly"));
           }
           catch(Exception $e)
           {
               $this->getWorkweekCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect('workweek/list');
    }

    /**
     *
     * @return array
     */
    public function updateAction()
    {

    }

    /**
     * @module Schedule
     * @action Deactivate
     */
    public function deleteAction(){
        $id = $this->getRequest()->getParam('id');
        $workweek = $this->findByID($id);

        try
        {
            $this->getWorkweekCatalog()->beginTransaction();

            $workweek->setStatus(Workweek::$Status['Inactive']);
            $this->getWorkweekCatalog()->update($workweek);
            $this->newLogForDelete($workweek);

            $this->getWorkweekCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Schedule was successfully deactivated"));
        }
        catch(Exception $e)
        {
            $this->getWorkweekCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('workweek/list');
    }

    /**
     * @module Schedule
     * @action Reactivate
     */
    public function reactivateAction(){
        $id = $this->getRequest()->getParam('id');
        $workweek = $this->findByID($id);

        try
        {
            $this->getWorkweekCatalog()->beginTransaction();

            $workweek->setStatus(Workweek::$Status['Active']);
            $this->getWorkweekCatalog()->update($workweek);
            $this->newLogForReactivate($workweek);

            $this->getWorkweekCatalog()->commit();
            $this->setFlash('ok', $this->i18n->_("The Schedule was successfully activated"));
        }
        catch(Exception $e)
        {
            $this->getWorkweekCatalog()->rollBack();
            $this->setFlash('error', $this->i18n->_($e->getMessage()));
        }
        $this->_redirect('workweek/list');
    }

    /**
     * @module Schedule
     * @action Tracking
     */
    public function trackingAction(){
        $id = $this->getRequest()->getParam('id');
        $workweek = $this->findByID($id);
        $this->view->workweekLogs = $logs = WorkweekLogQuery::create()->whereAdd('id_workweek', $id)->find();
        $this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
    }

    /**
     *
     * @param int $id
     * @return Workweek
     */
    private function findByID($id){
        return WorkweekQuery::create()
            ->findByPKOrThrow($id, $this->i18n->_("The Schedule with id not exists, id: ") . $id);
    }

    /**
     *
     * @param array $params
     * @return array
     */
    protected function validate($params){
        $errors = array();
        if( empty($params['name']) ){
            $errors['name'][] = $this->i18n->_('This field is required.');
        }
        return $errors;
    }

    /**
     * @param Workweek $workweek
     * @return \Application\Model\Bean\WorkweekLog
     */
    protected function newLogForCreate(Workweek $workweek){
        return $this->newLog($workweek, \Application\Model\Bean\WorkweekLog::$EventTypes['Create'] );
    }

    /**
     * @param Workweek $workweek
     * @return \Application\Model\Bean\WorkweekLog
     */
    protected function newLogForUpdate(Workweek $workweek){
        return $this->newLog($workweek, \Application\Model\Bean\WorkweekLog::$EventTypes['Update'] );
    }

    /**
     * @param Workweek $workweek
     * @return \Application\Model\Bean\WorkweekLog
     */
    protected function newLogForDelete(Workweek $workweek){
        return $this->newLog($workweek, WorkweekLog::$EventTypes['Delete'] );
    }

    /**
     * @param Workweek $workweek
     * @return \Application\Model\Bean\WorkweekLog
     */
    protected function newLogForReactivate(Workweek $workweek){
        return $this->newLog($workweek, WorkweekLog::$EventTypes['Reactivate'] );
    }

    /**
     * @return \Application\Model\Bean\WorkweekLog
     */
    private function newLog(Workweek $workweek, $eventType){
        $now = \Zend_Date::now();
        $log = WorkweekLogFactory::createFromArray(array(
            'id_workweek' => $workweek->getIdWorkweek(),
            'id_user' => $this->getUser()->getBean()->getIdUser(),
            'date_log' => $now->get('yyyy-MM-dd HH:mm:ss'),
            'event_type' => $eventType,
            'note' => '',
        ));
        $this->getCatalog('WorkweekLogCatalog')->create($log);
        return $log;
    }

    /**
     * @return \Application\Model\Catalog\WorkweekCatalog
     */
    protected function getWorkweekCatalog(){
        return $this->getContainer()->get('WorkweekCatalog');
    }

    /**
     * @return \Application\Model\Catalog\WorkdayCatalog
     */
    protected function getWorkdayCatalog(){
        return $this->getContainer()->get('WorkdayCatalog');
    }

    /**
     *
     */
    protected function assignCombos(){
        $this->view->days = array_flip(WorkDay::$Days);
        $this->view->hours = $this->getHours();
    }

    /**
     * Obtiene los elementos del select de Horas
     * @return array
     */
    protected function getHours()
    {
        $hours = array('' => '',);
        for ( $i = 0 ; $i <= 23 ; $i++  ){
            $h = str_pad($i, 2, '0', STR_PAD_LEFT);
            $hours["{$h}:00"] = "{$h}:00";
            $hours["{$h}:30"] = "{$h}:30";
        }
        return $hours;
        
    }
   


}
