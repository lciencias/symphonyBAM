<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

use Application\Controller\CrudController;
use Application\Model\Bean\Employee;
use Application\Model\Bean\Ticket;
use Application\Model\Bean\TicketLog;
use Application\Model\Bean;
use Application\Model\Factory;
use Application\Query\EmployeeQuery;
use Application\Query\CompanyQuery;
use Application\Query\PhoneNumberQuery;
use Application\Query\EmailQuery;
use Application\Query\PositionQuery;
use Application\Query\AreaQuery;
use Application\Query\LocationQuery;
use Application\Query\TicketTypeQuery;
use Application\Query\ImpactQuery;
use Application\Query\PriorityQuery;
use Application\Query\ChannelQuery;
use Application\Query\CategoryQuery;
use Application\Query\TicketQuery;
use Application\Query\TicketLogQuery;
use Application\Query\UserQuery;
use Application\Query\AssignmentQuery;
use Application\Query\ResolutionQuery;
use Application\Query\AttachmentQuery;
use Application\Query\UserLogQuery;
use Application\Query;
use Application\Model\Bean\Location;
use Application\Query\ServiceLevelQuery;

/**
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class TicketController extends CrudController
{

	/**
	 * (non-PHPdoc)
	 * @see Application\Controller.CrudController::getMaxPerPage()
	 */
	protected function getMaxPerPage(){
		return 50;
	}

	/**
	 * @module Tickets
	 * @action List
	 */
	public function indexAction(){
		return $this->_redirect("ticket/list");
	}

	/**
	 * @module Tickets
	 * @action List
	 * list all objects
	 */
	public function listAction()
	{
		$this->assignCombos();
		$this->view->users = array('' => $this->i18n->_('All')) + UserQuery::create()->actives()->find()->toCombo();

		if( $this->getRequest()->isPost() || $this->getRequest()->getParam('search') )
		{
			$idCompany = $this->getRequest()->getParam('id_company');
			$this->view->page = $page = $this->getRequest()->getParam('page') ?: 1;
			$params = $this->getRequest()->getParams();
			$total = TicketQuery::create()->filter($params)->count();
			$this->view->params = $params;
			$this->view->tickets = $tickets = TicketQuery::create()
			->filter($params)
			->page($page, $this->getMaxPerPage())
			->addDescendingOrderBy(Ticket::CREATED)
			->find();

			$this->view->registerLogs = $tickets->map(function (Ticket $ticket){
				return array(
						$ticket->getIdTicket() => TicketLogQuery::create()
						->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
						->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Create'])
						->findOneOrThrow("The ticket log not exists")
				);
			});

			if( $idCompany ){
				$this->assignCategoriesByIdCompany($idCompany);
			}
			if( !$tickets->isEmpty() ){
				$this->view->employees = EmployeeQuery::create()->whereAdd('id_employee', $tickets->getEmployeeIds())->find()->toCombo();
				$this->view->registeredUsers = UserQuery::create()->whereAdd('id_user', $tickets->getUserIds())->find()->toCombo();
				$this->view->categories = $this->translateCombo(CategoryQuery::create()->whereAdd('id_category', $tickets->getCategoryIds())->find()->toCombo());
			}
			$this->view->paginator = $this->createPaginator($total, $page);
		}

		$categories = CategoryQuery::create()->find();
		$this->view->nestedCategories = $categories->filterRoot()->toNestedArray($categories);
		$this->view->locations = array('') + LocationQuery::create()
		->addAscendingOrderBy(Location::NAME)
		->find()->toCombo();



		$this->view->setTpl("List");
	}

	/**
	 * @module Tickets
	 * @action My tickets
	 */
	public function mineAction(){
		$this->getRequest()->setParam('mine', true);
		$this->getRequest()->setParam('search', true);
		$this->getRequest()->setParam('id_employee', $this->getUser()->getBean()->getIdEmployee());
		return $this->listAction();
	}

	/**
	 * @module Tickets
	 * @action Tickets Assigned
	 */
	public function ticketsAssignedAction(){
		$this->getRequest()->setParam('mine', true);
		$this->getRequest()->setParam('search', true);
		$this->getRequest()->setParam('id_user_assigned', $this->getUser()->getBean()->getIdUser());
		$this->getRequest()->setParam('not_closed', true);
		return $this->listAction();
	}

	/**
	 * @module Tickets
	 * @action New My Ticket
	 */
	public function myTicketAction(){
		$this->getRequest()->setParam('id_employee', $this->getUser()->getBean()->getIdEmployee());
		return $this->newAction();
	}

	/**
	 * @module Tickets
	 * @action New Ticket
	 * Form for new objects
	 */
	public function newAction()
	{
		$idEmployee = $this->getRequest()->getParam('id_employee');
		$this->view->employee = $employee = $this->findEmployeeById($idEmployee);

		$this->view->actionForm = "create";
		$this->assignEmployeeInfo($employee);
		$this->assignCategoriesByIdCompany($employee->getIdCompany());
		$this->assignCombos();

		$this->view->setTpl("Form");
	}

	/**
	 * @module Tickets
	 * @action Edit
	 * Form to edit an object
	 */
	public function editAction()
	{
		$idTicket = $this->getRequest()->getParam('id_ticket');
		$ticket = $this->findTicketById($idTicket);

		$this->view->employee = $employee = $this->findEmployeeById($ticket->getIdEmployee());

		$this->assignTicketInfo($ticket);
		$this->assignEmployeeInfo($employee);
		$this->assignCategoriesByIdCompany($employee->getIdCompany());
		$this->assignCombos($ticket);

		if( $ticket->getStatusName() == "Unread" &&
				$ticket->getIdUser() != $this->getUser()->getBean()->getIdUser() ){
			$this->getTicketService()->read($ticket, $this->getUser()->getBean());
		}

		$this->view->ticketMachine = $this->getTicketMachine();
		$this->view->post = $ticket->toArray();
		$this->view->isShow = $this->getRequest()->getParam('isShow', false);
		$this->view->actionForm = "update";
		$this->view->setTpl("Form");
	}

	/**
	 * @module Tickets
	 * @action Show
	 * Form to edit an object
	 */
	public function showAction(){
		$this->getRequest()->setParam('isShow', true);
		return $this->editAction();
	}

	/**
	 * @module Tickets
	 * @action New Ticket
	 * Create an Object
	 */
	public function createAction(){
		$params = $this->getRequest()->getParams();
		try{
			$ticket = $this->getTicketService()->create($params, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been created.'));
			$this->_redirect("ticket/edit/id_ticket/{$ticket->getIdTicket()}");
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
			$this->_redirect("ticket/new/id_employee/{$params['id_employee']}");
		}
	}

	/**
	 * @module Tickets
	 * @action Edit
	 * Update an Object
	 */
	public function updateAction(){
		$params = $this->getRequest()->getParams();
		try {
			$ticket = $this->findTicketById($params['id_ticket']);
			$this->getTicketService()->update($ticket, $params, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been updated.'));
		} catch (\Exception $e) {
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Cancel
	 */
	public function cancelAction(){
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			$this->getTicketService()->cancel($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been canceled.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Working
	 */
	public function workingAction(){
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			$this->getTicketService()->working($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been set as working on it.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Read
	 */
	public function readAction(){
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			$this->getTicketService()->read($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been read.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Reopen
	 */
	public function reopenAction(){
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			$this->getTicketService()->reopen($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been reopened.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Close
	 */
	public function closeAction(){
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			$this->getTicketService()->close($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been closed.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Resolve
	 */
	public function resolveAction()
	{
		$params = $this->getRequest()->getParams();
		try {
			$ticket = $this->findTicketById($params['id_ticket']);
			if( $this->getRequest()->isPost() ){
				$resolution = ResolutionQuery::create()->findByPKOrThrow($params['id_resolution'], $this->i18n->_("The resolution not exists"));
				$this->getTicketService()->resolve($ticket, $resolution, $this->getUser()->getBean(), $params['note']);
				$this->setFlash('ok', $this->i18n->_('The ticket has been resolved.'));
			}
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Assign
	 */
	public function assignAction()
	{
		try {
			$ticket = $this->findTicketById($this->getRequest()->getParam('id_ticket'));
			if( $this->getRequest()->isPost() ){
				$user = UserQuery::create()
				->findByPKOrThrow($this->getRequest()->getParam('id_user'), $this->i18n->_('The user not exists'));
				$this->getTicketService()->assign($ticket, $user, $this->getUser()->getBean());
				$this->setFlash('ok', $this->i18n->_('The ticket has been assigned.'));
			}
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Pause
	 */
	public function pauseAction(){
		$idTicket = $this->getRequest()->getParam('id_ticket');
		try {
			$ticket = $this->findTicketById($idTicket);
			$this->getTicketService()->pause($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been paused.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Resume
	 */
	public function resumeAction(){
		$idTicket = $this->getRequest()->getParam('id_ticket');
		try {
			$ticket = $this->findTicketById($idTicket);
			$this->getTicketService()->resume($ticket, $this->getUser()->getBean());
			$this->setFlash('ok', $this->i18n->_('The ticket has been resumed.'));
		}catch (Exception $e){
			$this->setFlash('error', $e->getMessage());
		}
		$this->_redirect($this->getUser()->getFullLastUrl());
	}

	/**
	 * @module Tickets
	 * @action Tracking
	 */
	public function trackingAction(){
		$id = $this->getRequest()->getParam('id_ticket');
		$ticket = $this->findTicketById($id);
		$this->view->ticketLogs = $logs = TicketLogQuery::create()
		->whereAdd('id_base_ticket', $ticket->getIdBaseTicket())
		->whereAdd('event_type', TicketLog::$TrackeableEvents)
		->find();
		$this->view->assignments = $logs->filter(function (TicketLog $ticketlog){
			return $ticketlog->getEventType() == TicketLog::$EventTypes['Assign'];
		})->map(function(TicketLog $ticketLog){
			$assignment = Query\AssignmentQuery::create()->findByPK($ticketLog->getChangedTo());
			return array($assignment->getIdAssignment() => $assignment);
		});
		$this->view->users = UserQuery::create()->whereAdd('id_user', $logs->getUserIds())->find()->toCombo();
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
				$checker = new \EasyCSV\Checker(array("ticket","tipocaso","prioridad","impacto","origen","elemento",
						"empleado","descripcion","fecregistro", "fecrealizar","usrregistro","usrasignado","fectermino","estatus",
						"usrtermino","fecresuelto","usrresolvio","solucion","feccancelado", "usrcancelo",
				));
				$checker
				->addRequired('ticket')
				->addRequired('tipocaso')
				->addRequired('prioridad')
				->addRequired('impacto')
				->addRequired('origen')
				->addRequired('elemento')
				->addRequired('empleado')
				;
				try {
					$checker->check($reader);
				} catch (\EasyCSV\ValidationException $e) {
					$this->view->errors = $e->getErrors();
					return ;
				}

				$ticketCatalog = $this->getCatalog('TicketCatalog');

				$resolution = Query\ResolutionQuery::create()->setLimit(1)->findOneOrThrow("No existe ninguna resolucion");

				try
				{
					$ticketCatalog->beginTransaction();

					foreach ($reader as $line => $row) {

						$ticketType = Query\TicketTypeQuery::create()
						->notCache()
						->filter(array('name' => $row['tipocaso']))
						->findOne();
						if( !$ticketType ){
							$ticketType = Factory\TicketTypeFactory::createFromArray(array(
									'name' => $row['tipocaso'],
									'status' => Bean\TicketType::$Status['Active'],
							));
							$this->getCatalog('TicketTypeCatalog')->create($ticketType);
						}

						$prioridad = Query\PriorityQuery::create()
						->notCache()
						->filter(array('name' => $row['prioridad']))
						->findOne();
						if( !$prioridad ){
							$prioridad = Factory\PriorityFactory::createFromArray(array(
									'name' => $row['prioridad'],
									'status' => Bean\Priority::$Status['Active'],
							));
							$this->getCatalog('PriorityCatalog')->create($prioridad);
						}


						$impact = Query\ImpactQuery::create()
						->notCache()
						->filter(array('name' => $row['impacto']))
						->findOne();
						if( !$impact ){
							$impact = Factory\ImpactFactory::createFromArray(array(
									'name' => $row['impacto'],
									'status' => Bean\Impact::$Status['Active'],
							));
							$this->getCatalog('ImpactCatalog')->create($impact);
						}


						$channel = Query\ChannelQuery::create()
						->notCache()
						->filter(array('name' => $row['origen']))
						->findOne();
						if( !$channel ){
							$channel = Factory\ChannelFactory::createFromArray(array(
									'name' => $row['origen'],
									'status' => Bean\Channel::$Status['Active'],
							));
							$this->getCatalog('ChannelCatalog')->create($channel);
						}
						$category = Query\CategoryQuery::create()
						->findByPKOrThrow($row['elemento'], "No existe la categoria");
						$employee = Query\EmployeeQuery::create()
						->findByPKOrThrow($row['empleado'], "No existe el empleado");
						$registerUser = Query\UserQuery::create()
						->filter(array('username' => $row['usrregistro']))
						->findOneOrThrow("No existe el usuario");
						$ticket = $this->getTicketService()->create(array(
								'description' => $row['descripcion'],
								'id_category' => $category->getIdCategory(),
								'id_channel' => $channel->getIdChannel(),
								'id_company' => $employee->getIdCompany(),
								'id_employee' => $employee->getIdEmployee(),
								'id_impact' => $impact->getIdImpact(),
								'id_priority' => $prioridad->getIdPriority(),
								'id_ticket_type' => $ticketType->getIdTicketType(),
								'scheduled_date' => $row['fecrealizar'],
						), $registerUser, false);

						$fecregistro = new Zend_Date($row['fecregistro'], 'yyyy-MM-dd HH:mm:ss');
						$fecasignacion = clone $fecregistro;
						$fecasignacion->addMinute(15)->addSecond(15);
						$fecasignacion = $fecasignacion->get('yyyy-MM-dd HH:mm:ss');

						$ticket->setCreated($fecregistro->get('yyyy-MM-dd HH:mm:ss'));
						$ticketCatalog->update($ticket);

						$this->getTicketService()->read($ticket, $registerUser);

						$ticketCatalog->getDb()
						->query("UPDATE pcs_symphony_ticket_logs SET date_log = '{$fecregistro->get('yyyy-MM-dd HH:mm:ss')}'
						WHERE id_ticket = {$ticket->getIdTicket()}");


						$ticketLogs = implode(',', Query\TicketLogQuery::create()->filter(array(
								'id_ticket' => $ticket->getIdTicket(),
						))->find()->getPrimaryKeys());

						if( $row['usrasignado'] ){
							$assignedUser = Query\UserQuery::create()
							->filter(array('username' => $row['usrasignado']))
							->findOneOrThrow("No existe el usuario");
							$this->getTicketService()->assign($ticket, $assignedUser, $registerUser);
						}

						if( $row['estatus'] == 'Cancelado' ){

							$ticketCatalog->getDb()
							->query("UPDATE pcs_symphony_ticket_logs SET date_log = '{$fecasignacion}'
							WHERE id_ticket = {$ticket->getIdTicket()} AND id_ticket_log NOT IN({$ticketLogs})");

							$cancelUser = Query\UserQuery::create()
							->filter(array('username' => $row['usrcancelo']))
							->findOneOrThrow("No existe el usuario");
							$this->getTicketService()
							->cancel($ticket, $cancelUser, $row['solucion'], $row['feccancelado']);
						}else{
							$this->getTicketService()
							->working($ticket, $assignedUser);

							$ticketCatalog->getDb()
							->query("UPDATE pcs_symphony_ticket_logs SET date_log = '{$fecasignacion}'
							WHERE id_ticket = {$ticket->getIdTicket()} AND id_ticket_log NOT IN({$ticketLogs})");

							if( $row['estatus'] != 'Working' ){

								$this->getTicketService()->resolve($ticket, $resolution, $assignedUser, $row['solucion'], $row['fecresuelto']);

								if( $row['estatus'] == 'Cerrado' ){
									$userClose = Query\UserQuery::create()
									->filter(array('username' => $row['usrtermino']))
									->findOneOrThrow("No existe el usuario");
									$this->getTicketService()->close($ticket, $userClose, $row['fectermino']);
								}
							}
						}

					}

					$ticketCatalog->getDb()
					->query("DELETE FROM pcs_symphony_notifications");

					//throw new Exception("dev");
					$ticketCatalog->commit();
				}
				catch (\Exception $e) {
					$ticketCatalog->rollBack();
					throw $e;
				}
			}
		}
	}

	/**
	 * delete an object
	 */
	public function deleteAction(){

	}

	/**
	 *
	 */
	public function filterCategoryAction(){
		$this->assignCategoriesByIdCompany($this->getRequest()->getParam('id_company'));
		$this->view->setLayoutFile(null);
	}

	/**
	 *
	 */
	private function assignCombos(Ticket $ticket = null)
	{
		$allOption = array('' => $this->i18n->_('All'));

		$this->view->statuses = $this->toFilterSelect(array_flip(Ticket::$Statuses));

		$companies = CompanyQuery::create()->find();
		$channels = ChannelQuery::create()->find();
		$priorities = PriorityQuery::create()->find();
		$impacts = ImpactQuery::create()->find();
		$ticketTypes = TicketTypeQuery::create()->find();
		$resolutions = ResolutionQuery::create()->find();

		$this->view->allOption = $allOption;
		$this->view->companies = $allOption + $companies->actives()->toCombo();
		$this->view->resolutions = $resolutions->actives()->toCombo();

		$channelsActives = $channels->actives();
		$prioritiesActives = $priorities->actives();
		$impactsActives = $impacts->actives();
		$ticketTypesActives = $ticketTypes->actives();

		if( $ticket instanceof Ticket ){
			$channelsActives->append($channels->getByPK($ticket->getIdChannel()));
			if ($ticket->getIdPriority()) 
			$prioritiesActives->append($priorities->getByPK($ticket->getIdPriority()));
			if ($ticket->getIdImpact()) 
			$impactsActives->append($impacts->getByPK($ticket->getIdImpact()));
			$ticketTypesActives->append($ticketTypes->getByPK($ticket->getIdTicketType()));
		}

		$this->view->channels = $this->translateCombo($channelsActives->toCombo());
		$this->view->priorities = $this->translateCombo($prioritiesActives->toCombo());
		$this->view->impacts = $this->translateCombo($impactsActives->toCombo());
		$this->view->ticketTypes = $this->translateCombo($ticketTypesActives->toCombo());

		$this->view->allCompanies = $this->translateCombo($companies->toCombo());
		$this->view->allChannels = $this->translateCombo($channels->toCombo());
		$this->view->allPriorities = $this->translateCombo($priorities->toCombo());
		$this->view->allImpacts = $this->translateCombo($impacts->toCombo());
		$this->view->allTicketTypes = $this->translateCombo($ticketTypes->toCombo());
		$this->view->allResolutions = $this->translateCombo($resolutions->toCombo());
		$this->view->ticketMachine = $this->getTicketMachine();
	}

	/**
	 *
	 * @param Ticket $ticket
	 */
	private function assignTicketInfo(Ticket $ticket)
	{
		$this->view->ticket = $ticket;
		$this->view->registeredByUser = UserQuery::create()->findByPK($ticket->getIdUser());
		$this->view->percentageService = $this->getServiceLevelService()->getPercentageService($ticket);
		$this->view->timeOfService = $this->getServiceLevelService()->getServiceTime($ticket);
		$this->view->expiredTime = $this->getServiceLevelService()->getExpiredTime($ticket);
		$this->view->timeToExpire = $this->getServiceLevelService()->getTimeToExpire($ticket);
		$this->view->elapsedNaturalDays = $this->getServiceLevelService()->getElapsedDays($ticket, true);
		$this->view->elapsedDays = $this->getServiceLevelService()->getElapsedDays($ticket);
		$this->view->serviceLevelTime = $this->getServiceLevelService()->getServiceLevelTime($ticket);
		$this->view->expirationDate = $this->getServiceLevelService()->getExpirationDate($ticket);
		$this->view->registerLog = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Create'])
		->findOneOrThrow("The ticket log not exists");

		$this->view->attachments = AttachmentQuery::create()
		->whereAdd('id_base_ticket', $ticket->getIdBaseTicket())
		->find();

		$category = CategoryQuery::create()
		->findByPKOrThrow($ticket->getIdCategory(), $this->i18n->_("The category not exists"));
		$serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($category->getIdServiceLevel(), "The Service Level not exists");
		$this->view->resolutionTime = $serviceLevel->getResolutionDuration();
		$this->view->responseTime = $serviceLevel->getResponseDuration();
		$this->view->usersInGroup = UserQuery::create()
		->innerJoinGroup()
		->whereAdd('Group.id_group', $category->getIdGroup())
		->actives()
		->find()->toCombo();

		if( $ticket->getIdAssignment() ){
			$this->view->assignment = $assignment = AssignmentQuery::create()
			->findByPKOrThrow($ticket->getIdAssignment(), $this->i18n->_('The Assignment not exists'));
			$this->view->userAssigned = $user = UserQuery::create()
			->findByPKOrThrow($assignment->getIdUser(), $this->i18n->_('The User not exists'));
		}

	}

	/**
	 *
	 * @param Employee $employee
	 */
	private function assignEmployeeInfo(Employee $employee){
		$this->view->company = CompanyQuery::create()->findByPKOrThrow($employee->getIdCompany(), "");
		$this->view->area = AreaQuery::create()->findByPKOrThrow($employee->getIdArea(), "");
		$this->view->location = LocationQuery::create()->findByPKOrThrow($employee->getIdLocation(), "");
		$this->view->position = PositionQuery::create()->findByPKOrThrow($employee->getIdPosition(), "");
		$this->view->phoneNumbers = PhoneNumberQuery::create()
		->innerJoinPerson()->whereAdd('Person.id_person', $employee->getIdPerson())->find();
		$this->view->emails = EmailQuery::create()
		->innerJoinPerson()->whereAdd('Person.id_person', $employee->getIdPerson())->find();
	}

	/**
	 *
	 * @param int $idCompany
	 */
	private function assignCategoriesByIdCompany($idCompany){
		$categories = CategoryQuery::create()->whereAdd('id_company', $idCompany)->actives()->find();
		if (!$categories->count()){
			$this->setFlash('warning', $this->i18n->_('Es necesario que su empresa tenga asignadas categorias para poder crear un ticket'));
			$this->_redirect('ticket/list');
		}
		$this->view->nestedCategories = $categories->filterRoot()->toNestedArray($categories);
	}

	/**
	 *
	 * @param int $id
	 * @return Employee
	 */
	private function findEmployeeById($id){
		return EmployeeQuery::create()
		->findByPKOrThrow($id, $this->i18n->_("The Employee with id not exists:", $id));
	}

	/**
	 *
	 * @param int $id
	 * @return Ticket
	 */
	private function findTicketById($id){
		return TicketQuery::create()
		->findByPKOrThrow($id, $this->i18n->_("The Ticket with id not exists:", $id));
	}

	/**
	 * @return Application\Service\TicketService
	 */
	private function getTicketService(){
		return $this->getContainer()->get('TicketService');
	}


	/**
	 * @module Tickets
	 * @action Employees
	 * @return array
	 */
	public function employeesAction()
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


}


