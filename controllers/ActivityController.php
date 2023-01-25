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

use Application\Query\TicketClientQuery;

use Application\Model\Catalog\ActivityCatalog;
use Application\Model\Factory\ActivityFactory;
use Application\Model\Factory;
use Application\Model\Bean\Activity;
use Application\Model\Bean;
use Application\Model\Bean\User;
use Application\Query;
use Application\Event\EmailEvent;
use Application\Query\ActivityQuery;
use Application\Query\UserQuery;
use Application\Query\TicketQuery;
use Application\Form\ActivityForm;
use Application\Controller\CrudController;
use PHPeriod\Period;

/**
 *
 * @author chente
 */
class ActivityController extends CrudController
{

    /**
     * @module Activity
     * @action List
     * @return array
     */
    public function indexAction(){
        return $this->_forward('list');
    }

    /**
     * @module Activity
     * @action List
     * @return array
     */
    public function listAction()
    {
    	$idTicket = $this->getRequest()->getParam('id_ticket');
    	$ticket = TicketQuery::create()->findByPK($idTicket);
    	 
        $this->view->activities = $activities = ActivityQuery::create()
            ->whereAdd(Activity::ID_BASE_TICKET, $ticket->getIdBaseTicket())
            ->addAscendingOrderBy(Activity::START_DATE)
            ->find();
        $this->view->users = UserQuery::create()->pk($activities->getUserIds())->find()->toCombo();
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
     * @module Activity
     * @action Create
     * @return array
     */
    public function createAction()
    {
        $params = $this->getRequest()->getParams();
        if (isset($params['id_ticket']))
        	$ticket = TicketQuery::create()->findByPKOrThrow($params['id_ticket'], $this->i18n->_("The ticket not exists"));
        else if (isset($params['id_ticket_client']))
        	$ticket = TicketClientQuery::create()->findByPK($params['id_ticket_client']);
        $params['id_base_ticket'] = $ticket->getIdBaseTicket();
        if( $this->getRequest()->isPost() ){
           try
           {
               $this->getActivityCatalog()->beginTransaction();
				$date = new \Zend_Date();
               $params['start_date'] .= ':00';
// 				print_r($params['start_date']).'<br>';
               $params['start_date'] = $date->get('yyyy-MM-dd hh:mm:ss');
               $date->add('00:00:01', \Zend_Date::TIMES);
//                print_r($params['start_date']);die;
               $params['end_date'] = $date->get('yyyy-MM-dd hh:mm:ss');
               $activity = $this->createActivity($params, $this->getUser()->getBean());
               $this->getEventDispatcher()->dispatch(isset(
               		$params['id_ticket_client'])
               		? EmailEvent::TICKET_CLIENT_ACTIVITY 
               		: EmailEvent::TICKET_ACTIVITY, 
               		new EmailEvent(array(
               		'ticket' => $ticket,
               		'user' =>  $this->getUser()->getBean(),
               )));
               $this->getActivityCatalog()->commit();
               $this->setFlash('ok', $this->i18n->_("Has been saved successfully"));
           }
           catch(Exception $e)
           {
               $this->getActivityCatalog()->rollBack();
               $this->setFlash('error', $this->i18n->_($e->getMessage()));
           }
        }
        $this->_redirect($this->getUser()->getFullLastUrl());
    }

    /**
     *
     * @param array $params
     * @param User $user
     * @return Ticket
     */
    protected function createActivity($params, User $user)
    {
        $period = new Period($params['start_date'], $params['end_date']);
        $activity = ActivityFactory::createFromArray($params);
        $activity->setIdUser($user->getIdUser());
        $activity->setStartDate($period->getStartDate()->format(Period::MYSQL_FORMAT));
//         $activity->setEndDate($period->getEndDate()->format(Period::MYSQL_FORMAT));
        $activity->setEndDate(null);
        $this->getActivityCatalog()->create($activity);
    }
    /**
     * @module Activity
     * @action End Activity
     * @return array
     */
    public function endActivityAction(){
    	$id = $this->getRequest()->getParam('id');
    	$date = new \Zend_Date();
    	try {
    		$activity = ActivityQuery::create()->findByPK($id);
    		if(!$activity)
    			throw new Exception('The activity does not exist');
    		$activity->setEndDate($date->get('yyyy-MM-dd hh:mm:ss'));
    		$this->getActivityCatalog()->beginTransaction();
    		$this->getActivityCatalog()->update($activity);
    		$this->getActivityCatalog()->commit();
    		$this->setFlash('ok', $this->i18n->_("Has been saved successfully"));
    	} catch (Exception $e) {
    		$this->getActivityCatalog()->rollBack();
    		$this->setFlash('error', $e->getMessage());
    	}
    	$this->_redirect($this->getUser()->getFullLastUrl());
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
                $checker = new \EasyCSV\Checker(array("ticket","fecha","usuario","descripcion","fecinicio","fecfinal"));
                $checker->addRequired("ticket");
                $checker->addRequired("fecha");
                $checker->addRequired("usuario");
                $checker->addRequired("descripcion");
                $checker->addRequired("fecinicio");
                $checker->addRequired("fecfinal");
                try {
                    $checker->check($reader);
                } catch (\EasyCSV\ValidationException $e) {
                    $this->view->errors = $e->getErrors();
                    return ;
                }

                $activityCatalog = $this->getCatalog('ActivityCatalog');
                try
                {
                    $activityCatalog->beginTransaction();

                    foreach ($reader as $line => $row){
                        $row = array_map('trim', $row);

                        $ticket = TicketQuery::create()->findByPKOrThrow($row['ticket'], "No existe el ticket");
                        $user = Query\UserQuery::create()->filter(array('username' => $row['usuario']))
                            ->findOneOrThrow("El usuario no existe");

                        $params = array(
                            'id_ticket' => $ticket->getIdTicket(),
                            'start_date' => $row['fecinicio'],
                            'end_date' => $row['fecfinal'],
                            'note' => $row['descripcion'],
                        );
                        $this->createActivity($params, $user);
                    }

                    $activityCatalog->commit();
                }
                catch (\Exception $e) {
                    $activityCatalog->rollBack();
                    throw $e;
                }
            }
        }
    }

    /**
     *
     * @return array
     */
    public function updateAction(){}

    /**
     *
     */
    public function deleteAction(){}


    /**
     * @return \Application\Model\Catalog\ActivityCatalog
     */
    protected function getActivityCatalog(){
        return $this->getContainer()->get('ActivityCatalog');
    }

}
