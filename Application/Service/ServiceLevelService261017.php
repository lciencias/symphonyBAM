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

namespace Application\Service;

use Application\Query\ClientCategoryQuery;

use Application\Model\Bean\ClientCategory;

use Application\Model\Bean\TicketClient;

use Application\Model\Bean\Ticket;

use Application\Storage\Chain;

use Symfony\Component\Templating\Storage\Storage;

use Application\Storage\StorageFactory;

use PHPeriod\Duration;

use Application\Model\Exception\BaseTicketException;

use Application\Query\WorkweekQuery;

use Application\Query\GroupQuery;

use Application\Model\Bean\Group;

use Application\Query\ServiceLevelQuery;
use Application\Model\Bean\ServiceLevel;
use Application\Query\CategoryQuery;
use Application\Model\Collection\BaseTicketCollection;
use Application\Model\Bean\BaseTicket;
use Query\Criterion;
use Application\Query\TicketLogQuery;
use Application\Model\Bean\TicketLog;
use PHPeriod\PeriodCollection;
use PHPeriod\Period;
use Application\Model\Bean\Calendar;
use Application\Query\CalendarQuery;
use Application\Model\Bean\Workday;
use Application\Query\WorkdayQuery;
use Application\Model\Bean\Workweek;

/**
 *
 * BaseTicketService
 *
 * @category Application\Service
 * @author guadalupe, chente
 */
class ServiceLevelService extends AbstractService
{

	/**
	 *
	 * @var Application\Storage\Storage
	 */
	private $storage;

	/**
	 *
	 */
	public function __construct(){
		$this->storage = StorageFactory::create('memory');
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return int
	 */
	public function getPercentageService(BaseTicket $ticket)
	{
		$serviceLevelTime = $this->getServiceLevelTime($ticket)->getSeconds();

		$percentage = 0;
		if( $serviceLevelTime > 0 ){
			$duration = $this->getServiceTime($ticket);
			$percentage = number_format(( $duration->getSeconds() / $serviceLevelTime ) * 100, 2);
		}

		return $percentage;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return Duration
	 */
	public function getServiceLevelTime(BaseTicket $ticket)
	{
		if ($ticket instanceof Ticket)
			$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The categoy not exists");
		else if ($ticket instanceof TicketClient)
			$category = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The categoy not exists");
		$serviceLevel = ServiceLevelQuery::create()->findByPKOrThrow($category->getIdServiceLevel(), "The Service Level not exists");
		return $serviceLevel->getDuration();
	}

	/**
	 * @param BaseTicket $ticket
	 * @return Duration
	 */
	public function getExpiredTime(BaseTicket $ticket)
	{
		$serviceLevelTime = $this->getServiceLevelTime($ticket)->getSeconds();
		$serviceTime = $this->getServiceTime($ticket)->getSeconds();

		if( $serviceLevelTime >= $serviceTime  ){
			return  new Duration(0);
		}


		return new Duration($serviceTime - $serviceLevelTime);
	}

	/**
	 * @param BaseTicket $ticket
	 * @return Duration
	 */
	public function getTimeToExpire(BaseTicket $ticket)
	{
		$serviceLevelTime = $this->getServiceLevelTime($ticket)->getSeconds();
		$serviceTime = $this->getServiceTime($ticket)->getSeconds();

		if( $serviceLevelTime <= $serviceTime  ){
			return  new Duration(0);
		}


		return new Duration($serviceLevelTime - $serviceTime);
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return Duration
	 */
	public function getServiceTimeNew(BaseTicket $ticket)
	{
		$now = new \Zend_Date();		
		$category      = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The category not exists");
		$ser           = ServiceLevelQuery::create()->findByPKOrThrow($category->getIdServiceLevel(), "The Nivel Service not exists");
		$seconsService = ((double)$ser->getResolutionTime() + (int)$ser->getResponseTime()) * 60;		
		$daysenWeek    = $this->getNumberNotWorking($ticket->getCreated(), $now->get('yyyy-MM-dd HH:mm:ss'));
		$end           = $now->addDay((-1 * $daysenWeek));	
		$start = $date = new \DateTime($ticket->getCreated());		
		$endF  = new \DateTime($end->get('yyyy-MM-dd HH:mm:ss'));		
		$dif = $start->diff($endF);
		$second =  ($dif->format('%d') * 24 * 60 * 60) + ($dif->format('%H') * 60 * 60) +($dif->format('%I') * 60) +($dif->format('%S') + 0);
		$por = number_format($second * 100 /$seconsService,2,'.',',');
		$diferencia = $this->seg_a_dhms($seconsService - $second);
		if($diferencia < 0){
			return array($dif->format('%d dias %H horas %I minutos %S segundos'),$por,"Tiempo de nivel de Servicio vencido");
		}else{
			return array($dif->format('%d dias %H horas %I minutos %S segundos'),$por,$diferencia);
		}
	}
	
	public function seg_a_dhms($seg) {
		$d = floor($seg / 86400);
		$h = floor(($seg - ($d * 86400)) / 3600);
		$m = floor(($seg - ($d * 86400) - ($h * 3600)) / 60);
		$s = $seg % 60;
		return "$d Dias: $h horas: $m minutos: $s segundos";
	}
	
	public function getServiceTime(BaseTicket $ticket)
	{
		$key = "ServiceLevelService::getServiceTime({$ticket->getIdBaseTicket()})";
		if( $this->storage->exists($key) ){
			return $this->storage->load($key);
		}
		
		$duration = new Duration($this->getResponseTime($ticket)->getSeconds()
				+ $this->getResolutionTime($ticket)->getSeconds());
		$this->storage->save($key, $duration);
		return $duration;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return \Zend_Date
	 */
	public function getExpirationDateNvo(BaseTicket $ticket)
	{
		$startDate  = $this->getStartDate($ticket);
		$endDate = $this->getBaseTicketPeriodSeconds($ticket);
		return $endDate->get('yyyy-MM-dd HH:mm:ss');

	}

	public function getExpirationDate(BaseTicket $ticket)
	{
		$startDate = $this->getStartDate($ticket);
		$basePeriod = $this->getBaseTicketPeriod($ticket);
		$period = new Period($startDate->get('yyyy-MM-dd HH:mm:ss'), $basePeriod->getEndDate()->format(Period::MYSQL_FORMAT));
		$periodCollection = $period->toCollection()->intersectCollection($basePeriod);
		$seconds = $this->getServiceLevelTime($ticket)->getSeconds();
		$endDate = new \Zend_Date($periodCollection->truncate($seconds)->getEndDate()->format(Period::MYSQL_FORMAT), "yyyy-MM-dd HH:mm:ss");
		return $endDate;
	
	}
	/**
	 *
	 * @param BaseTicket $ticket
	 * @throws BaseTicketException
	 * @return Duration
	 */
	public function getResponseTime(BaseTicket $ticket){
		return $this->getResponsePeriod($ticket)->getDuration();
	}

	/**
	 * @param BaseTicket $ticket
	 * @throws BaseTicketException
	 * @return \PHPeriod\PeriodCollection
	 */
	public function getResponsePeriod(BaseTicket $ticket)
	{
		$startDate = $this->getStartDate($ticket);

		$logs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Response_End_Time'])
		->find();
		if( $logs->count() >= 2 ){
			throw new BaseTicketException("No pueden existir dos o mas logs de Response_End_Time");
		}
		$responseEndLog = $logs->read();
		if( $responseEndLog instanceof TicketLog ){
			$endDate = $responseEndLog->getDateLogAsZendDate();
		}else{
			$endDate = new \Zend_Date();
		}				
		if( $endDate->getTimestamp() < $startDate->getTimestamp() ){
			return new PeriodCollection();
		}
		$period = new Period($startDate->get('yyyy-MM-dd HH:mm:ss'), $endDate->get('yyyy-MM-dd HH:mm:ss'));
		$periodCollection = $period->toCollection()->intersectCollection($this->getBaseTicketPeriod($ticket));
		return $periodCollection;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return \Zend_Date
	 */
	private function getStartDate(BaseTicket $ticket)
	{
		if( $ticket->hasScheduledDate() ){			
			$startDate = $ticket->getScheduledDateAsZendDate();
			
		}else{
			$responseStartLog = $this->getResponseStartLog($ticket);
			$startDate = $responseStartLog->getDateLogAsZendDate();
		}

		return $startDate;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @throws BaseTicketException
	 * @return Duration
	 */
	public function getResolutionTime(BaseTicket $ticket)
	{
		$logs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Resolution_Start_Time'])
		->find();
		if( $logs->isEmpty() ){
			return new Duration(0);
		}

		if( $logs->count() >= 2 ){
			throw new BaseTicketException("No pueden existir dos o mas logs de Resolution_Start_Time");
		}

		$resolutionStartLog = $logs->read();
		$startDate = $resolutionStartLog->getDateLogAsZendDate();

		$resolutionEndLog = $this->getResolutionEndLog($ticket);
		if( $resolutionEndLog instanceof TicketLog ){
			$endDate = $resolutionEndLog->getDateLogAsZendDate();
		}else{
			$endDate = new \Zend_Date();
		}

		if( $endDate->getTimestamp() <= $startDate->getTimestamp() ){
			return new Duration(0);
		}

		$period = new Period($startDate->get('yyyy-MM-dd HH:mm:ss'), $endDate->get('yyyy-MM-dd HH:mm:ss'));
		$periodCollection = $period->toCollection()->intersectCollection($this->getBaseTicketPeriod($ticket));

		return $periodCollection->getDuration();
	}
	
	
	protected function getBaseTicketPeriodSeconds(BaseTicket $ticket)
	{
		$storage = StorageFactory::create('memory');
		if ($ticket instanceof Ticket)
			$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The categoy not exists");
		else if ($ticket instanceof TicketClient)
			$category = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The category not exists");
		
		$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exits");
		$workweek = WorkweekQuery::create()->findByPKOrThrow($group->getIdWorkweek(), "The workweek not exists");
		$ser      = ServiceLevelQuery::create()->findByPKOrThrow($category->getIdServiceLevel(), "The Nivel Service not exists");
		$dias     = (int)$ser->getResolutionTimeDays() + (int)$ser->getResponseTimeDays();

		if( $ticket->hasScheduledDate() ){
			$startDate = $ticket->getScheduledDateAsZendDate();
		}else{
			$startDate = $this->getResponseStartLog($ticket)->getDateLogAsZendDate();
		}		
		
		$endDate = clone $startDate;
		$endDate->addDay($dias);		
		$daysenWeek = $this->getNumberEndWeek($startDate, $endDate);
		if($daysenWeek > 0){
			$endDate = clone $startDate;
			$endDate->addDay($daysenWeek);
		}
		$seconds    = $this->getPausedPeriodTime($ticket);
		
		if($seconds > 0){
			$endDate->addSecond($seconds);
		}
		return $endDate;
	}
	

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return \PHPeriod\PeriodCollection
	 */
	protected function getBaseTicketPeriod(BaseTicket $ticket)
	{
		$storage = StorageFactory::create('memory');

		$key = "ServiceLevelService::getBaseTicketPeriod({$ticket->getIdBaseTicket()})";
		if( $storage->exists($key) ){
			$periodCollection = $storage->load($key);
			$periodCollection->rewind();
			return $periodCollection;
		}
		if ($ticket instanceof Ticket)
			$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The categoy not exists");
		else if ($ticket instanceof TicketClient)
			$category = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The category not exists");
		
		$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exits");
		$workweek = WorkweekQuery::create()->findByPKOrThrow($group->getIdWorkweek(), "The workweek not exists");
		$ser      = ServiceLevelQuery::create()->findByPKOrThrow($category->getIdServiceLevel(), "The Nivel Service not exists");
		$dias     = (int)$ser->getResolutionTimeDays() + (int)$ser->getResponseTimeDays();
		if( $ticket->hasScheduledDate() ){
			$startDate = $ticket->getScheduledDateAsZendDate();
		}else{
			$startDate = $this->getResponseStartLog($ticket)->getDateLogAsZendDate();
		}		
		$endDate = clone $startDate;
		$endDate->addDay($dias);		
		$daysenWeek = $this->getNumberEndWeek($startDate, $endDate);
		if($daysenWeek > 0){
			$endDate = clone $startDate;
			$endDate->addDay($daysenWeek);
		}
		$seconds    = $this->getPausedPeriodTime($ticket);
		
		if($seconds > 0){
			$endDate->addSecond($seconds);
		}
	
		$periodCollection = $this->getWorkweekPeriod($workweek, $startDate, $endDate)
		->subtractCollection($this->getPausedPeriod($ticket));
		$storage->save($key, $periodCollection);
		
		return $periodCollection;
	}

	
	public function getPausedPeriodTime(BaseTicket $ticket, \Zend_Date $startDate = null, \Zend_Date $endDate = null)
	{
		$seconds = 0;
		$periodCollection = new PeriodCollection();
		$pausedLogs = $this->getPausedLogs($ticket, $startDate, $endDate);
		if( $pausedLogs->isEmpty() ){
			return 0;
		}
	
		$resumedLogs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Resume'])
		->addAscendingOrderBy(TicketLog::DATE_LOG)
		->find();
	
		$diff = $pausedLogs->count() - $resumedLogs->count();
		if( !in_array($diff, array(0, 1)) ){
			throw new BaseTicketException("La diferencia de tickets no puede ser mayor de 1");
		}
	
		while ( $pausedLogs->valid() ) {
			$pausedLog = $pausedLogs->read();
			if( $resumedLogs->valid() ){
				$resumedLog = $resumedLogs->read();				
				$days = $this->getNumberNotWorking($pausedLog->getDateLog(), $resumedLog->getDateLog());
				$seconds = $this->getPeriodNotWorking($pausedLog->getDateLog(), $resumedLog->getDateLog());
			}else{
				$now  = new \Zend_Date();
				$now->addSecond(1);
				$days = $this->getNumberNotWorking($pausedLog->getDateLog(), $now->get('yyyy-MM-dd HH:mm:ss'));
				$seconds = $this->getPeriodNotWorking($pausedLog->getDateLog(), $now->get('yyyy-MM-dd HH:mm:ss'));
			}
			if($days > 0){
				$seconds = ($seconds - ($days * 24 * 60 *60 ));
			}
		}		
		return $seconds;
	}
	
	
	/**
	 *
	 * @param BaseTicket $ticket
	 * @param \Zend_Date $startDate
	 * @param \Zend_Date $endDate
	 * @return \PHPeriod\PeriodCollection
	 */
	public function getPausedPeriod(BaseTicket $ticket, \Zend_Date $startDate = null, \Zend_Date $endDate = null)
	{
		$periodCollection = new PeriodCollection();
		$pausedLogs = $this->getPausedLogs($ticket, $startDate, $endDate);
		

		if( $pausedLogs->isEmpty() ){
			return $periodCollection;
		}
		
		$resumedLogs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Resume'])
		->addAscendingOrderBy(TicketLog::DATE_LOG)
		->find();

		$diff = $pausedLogs->count() - $resumedLogs->count();
		if( !in_array($diff, array(0, 1)) ){
			throw new BaseTicketException("La diferencia de tickets no puede ser mayor de 1");
		}

		while ( $pausedLogs->valid() ) {
			$pausedLog = $pausedLogs->read();
			if( $resumedLogs->valid() ){
				$resumedLog = $resumedLogs->read();
				$periodCollection->append(new Period($pausedLog->getDateLog(), $resumedLog->getDateLog()));
			}else{
				$now  = new \Zend_Date();
				$now->addSecond(1);
				$periodCollection->append(new Period($pausedLog->getDateLog(), $now->get('yyyy-MM-dd HH:mm:ss')));
			}
		}
		return $periodCollection;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @param \Zend_Date $startDate
	 * @param \Zend_Date $endDate
	 * @return BaseTicketCollection
	 */
	private function getPausedLogs(BaseTicket $ticket, \Zend_Date $startDate = null, \Zend_Date $endDate = null)
	{
		$query = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Pause'])
		->addAscendingOrderBy(TicketLog::DATE_LOG);

		if( null != $startDate ){
			$query->whereAdd(TicketLog::DATE_LOG, $startDate->get('yyyy-MM-dd HH:mm:ss'), Criterion::GREATER_OR_EQUAL);
		}

		if( null != $endDate ){
			$query->whereAdd(TicketLog::DATE_LOG, $endDate->get('yyyy-MM-dd HH:mm:ss'), Criterion::LESS_OR_EQUAL);
		}

		return $query->find();
	}
	
	public function getPeriodNotWorking($startDate,$endDate){
		return strtotime($endDate) - strtotime($startDate);
	}


	public function getNumberNotWorking($startDate,$endDate){
		$saturday = $sunday = 0;
		$endWeek = 0;
		$segs = 86400;
		$nmdia = "";
		
		$startDate = substr($startDate,0,10)." 00:00:00";
		$endDate = substr($endDate,0,10)." 00:00:00";
		$unixStartDate = strtotime($startDate);
		$unixEndDate   = strtotime($endDate);
		$i = $unixStartDate;
		$between = array($startDate,$endDate);
		$calendar = CalendarQuery::create()->addColumns(array(Calendar::DAY_NUMBER,Calendar::IS_HOLIDAY))
				->whereAdd(Calendar::DATE, $between, CalendarQuery::BETWEEN)
				->fetchAll();
		$contador =  0;
		while ($i < $unixEndDate){					
			if( $calendar[$contador]['day_number'] == 1){  //DOMINGO
				$endWeek++;
			}
			if($calendar[$contador]['day_number'] == 7){  //SABADO
				$endWeek++;
			}
			if($calendar[$contador]['is_holiday'] == 1){  //DIA FESTIVO
				$endWeek++;
			}
			$i+=$segs;
			$contador++;
		}
		return (int)$endWeek;
	}
	
	
	/**
	 *
	 * @param \Zend_Date $startDate
	 * @param \Zend_Date $endDate
	 * @return int endWeek
	 */
	
	public function getNumberEndWeek(\Zend_Date $startDate, \Zend_Date $endDate){
		$saturday = $sunday = 0;
		$endWeek = 0;
		$segs = 86400;
		$nmdia = "";
		$unixStartDate = strtotime($startDate->get('yyyy-MM-dd'));
		$unixEndDate   = strtotime($endDate->get('yyyy-MM-dd'));
		$i = $unixStartDate;
		while ($i < $unixEndDate){			
			$i+=$segs;			
			$calendar = CalendarQuery::create()->addColumns(array(Calendar::DAY_NUMBER,Calendar::IS_HOLIDAY))
			->whereAdd(Calendar::DATE, date("Y-m-d", $i))
			->fetchAll();
			$endWeek++;
			if( $calendar[0]['day_number'] == 1){  //DOMINGO
				$unixEndDate = $unixEndDate + $segs;
				continue;
			}
			if($calendar[0]['day_number'] == 7){  //SABADO
				$unixEndDate = $unixEndDate + $segs;
				continue;
			}
			if($calendar[0]['is_holiday'] == 1){  //DIA FESTIVO
				$unixEndDate = $unixEndDate + $segs;
				continue;
			}
		}
		return (int)$endWeek;
	}
	
	
	public function getWorkweekPeriodHrs(Workweek $workweek, \Zend_Date $startDate, \Zend_Date $endDate)
	{
	
		$storage = new Chain(StorageFactory::create('memory'), StorageFactory::create('file'));
		$strStartDate = $startDate->get('yyyy-MM-dd HH:mm:ss');
		$strEndDate = $endDate->get('yyyy-MM-dd HH:mm:ss');
		echo"<BR>TIMES:  ".$strStartDate ."  ****  ".$strEndDate;
	
		$key = "ServiceLevelService::getWorkweekPeriod({$workweek->getIdWorkweek()}, {$strStartDate}, {$strEndDate})";
	
		if( $storage->exists($key) ){
			$periodCollection = $storage->load($key);
			$periodCollection->rewind();
			return $periodCollection;
		}
	
		$workdays = WorkdayQuery::create()
		->whereAdd(Workday::ID_WORKWEEK, $workweek->getIdWorkweek())
		->find();
	
		$between = array($strStartDate, $strEndDate);
	
		$calendar = CalendarQuery::create()
		->whereAdd(Calendar::IS_HOLIDAY, 0)
		->whereAdd(Calendar::DATE, $between, CalendarQuery::BETWEEN)
		->find();
	
	
		$self = $this;
		$periods = $calendar->map(function(Calendar $calendar) use($workdays, $self){
			$dayOfWeek = $calendar->getDateAsZendDate()->get(\Zend_Date::WEEKDAY_DIGIT) + 1;
			$workday = $workdays->filterByDayOfWeek($dayOfWeek)->read();
			$date = $calendar->getDate();
			return array( $date => $self->getPeriods($workday, $date));
		});
	
				
			$periodCollection = new PeriodCollection();
			foreach($periods as $info){
				foreach ($info as $period){
					if( $period instanceof Period ){
						$periodCollection->append($period);
					}
				}
			}
			$storage->save($key, $periodCollection);
			return $periodCollection;
	}
	/**
	 *
	 * @param Workweek $workweek
	 * @param \Zend_Date $startDate
	 * @param \Zend_Date $endDate
	 * @return \PHPeriod\PeriodCollection
	 */
	public function getWorkweekPeriod(Workweek $workweek, \Zend_Date $startDate, \Zend_Date $endDate)
	{
		
		$storage = new Chain(StorageFactory::create('memory'), StorageFactory::create('file'));
		$strStartDate = $startDate->get('yyyy-MM-dd');
		$strEndDate = $endDate->get('yyyy-MM-dd');
		$key = "ServiceLevelService::getWorkweekPeriod({$workweek->getIdWorkweek()}, {$strStartDate}, {$strEndDate})";
		
	/*	if( $storage->exists($key) ){
			$periodCollection = $storage->load($key);
			$periodCollection->rewind();
			return $periodCollection;
		}*/

		$workdays = WorkdayQuery::create()
		->whereAdd(Workday::ID_WORKWEEK, $workweek->getIdWorkweek())
		->find();
		
		$between = array($strStartDate, $strEndDate);
		
		$calendar = CalendarQuery::create()
		->whereAdd(Calendar::IS_HOLIDAY, 0)
		->whereAdd(Calendar::DATE, $between, CalendarQuery::BETWEEN)
		->find();

		
		$self = $this;
		$periods = $calendar->map(function(Calendar $calendar) use($workdays, $self){
			$dayOfWeek = $calendar->getDateAsZendDate()->get(\Zend_Date::WEEKDAY_DIGIT) + 1;
			$workday = $workdays->filterByDayOfWeek($dayOfWeek)->read();
			$date = $calendar->getDate();
			return array( $date => $self->getPeriods($workday, $date));
		});
			
		$periodCollection = new PeriodCollection();
		foreach($periods as $info){
			foreach ($info as $period){
				if( $period instanceof Period ){
					$periodCollection->append($period);
				}
			}
		}
		$storage->save($key, $periodCollection);
		return $periodCollection;
	}
	/**
	 * Utilizado para obtener la cantidad de dias y fracciones reales que han transcurrido desde que se dio de alta el ticket, sin importar el periodo de tiempo de trabajo
	 * @param Ticket $ticket
	 * @param Boolean $naturalDays
	 * @return Duration
	 */
	public function getElapsedDays(BaseTicket $ticket, $naturalDays = false)
	{
		if ($ticket instanceof Ticket)
			$category = CategoryQuery::create()->findByPKOrThrow($ticket->getIdCategory(), "The categoy not exists");
		else if ($ticket instanceof TicketClient)
			$category = ClientCategoryQuery::create()->findByPKOrThrow($ticket->getIdClientCategory(), "The category not exists");
		$group = GroupQuery::create()->findByPKOrThrow($category->getIdGroup(), "The group not exits");
		$workweek = WorkweekQuery::create()->findByPKOrThrow($group->getIdWorkweek(), "The workweek not exists");
		 
		if( $ticket->hasScheduledDate() ){
			$startDate = $ticket->getScheduledDateAsZendDate();
		}else{
			$startDate = $this->getResponseStartLog($ticket)->getDateLogAsZendDate();
		}
		$resolutionEndLog = $this->getResolutionEndLog($ticket);
		if( $resolutionEndLog instanceof TicketLog ){
			$endDate = $resolutionEndLog->getDateLogAsZendDate();
		}else{
			$endDate = new \Zend_Date();
		}
		$strStartDate = $startDate->get('yyyy-MM-dd');
		$strEndDate = $endDate->get('yyyy-MM-dd');
	
		$workdays = WorkdayQuery::create()
		->whereAdd(Workday::ID_WORKWEEK, $workweek->getIdWorkweek())
		->find();
	
		$between = array($strStartDate, $strEndDate);
		$calendarQuery = CalendarQuery::create()
		->whereAdd(Calendar::DATE, $between, CalendarQuery::BETWEEN);
		if(!$naturalDays)
			$calendarQuery
			->whereAdd(Calendar::IS_HOLIDAY, 0)
			->whereAdd(Calendar::DAY_NUMBER, $workdays->getWorkdaysNumbers());
		 
		$calendar = $calendarQuery->find();
		$self = $this;
		$periods = $calendar->map(function(Calendar $calendar) use($workdays, $self, $endDate){
			if ($endDate->compareDate($calendar->getDateAsZendDate()) === 0){
				$workday = $workdays->filterByDayOfWeek($calendar->getDayNumber())->read();
				return array( $calendar->getDate() => $self->getPeriods($workday, $calendar->getDate()));
			}else{
				$nextDay = clone $calendar->getDateAsZendDate();
				$nextDay->addDay(1);
				return array( $calendar->getDate() => array(new Period($calendar->getDate() . " 00:00:00", $nextDay->get('yyyy-MM-dd') . "00:00:00")));
			}
	
		});
		$periodCollection = new PeriodCollection();
		foreach($periods as $info){
			foreach ($info as $period){
				if( $period instanceof Period ){
					$periodCollection->append($period);
				}
			}
		}
		return $periodCollection->getDuration();
	}
	/**
	 *
	 * @param Workday $workday
	 * @return array
	 */
	public function getPeriods(Workday $workday = null, $date)
	{
		$periods = array();
		if( $workday instanceof Workday ){
			if( null == $workday->getLunchStartTime() || null == $workday->getLunchEndTime() ){
				$periods[] = new Period("{$date} {$workday->getStartTime()}", "{$date} {$workday->getEndTime()}");
			}else{
				$periods[] = new Period("{$date} {$workday->getStartTime()}", "{$date} {$workday->getLunchStartTime()}");
				$periods[] = new Period("{$date} {$workday->getLunchEndTime()}", "{$date} {$workday->getEndTime()}");
			}
		}

		return $periods;
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return TicketLog
	 * @throws BaseTicketException
	 */
	private function getResponseStartLog(BaseTicket $ticket)
	{
		$logs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Response_Start_Time'])
		//->useMemoryCache()
		->find();

		if( $logs->isEmpty() ){
			throw new BaseTicketException("No existe log de Response_Start_Time");
		}

		if( $logs->count() >= 2 ){
			throw new BaseTicketException("No pueden existir dos o mas logs de Response_Start_Time");
		}

		return $logs->read();
	}

	/**
	 *
	 * @param BaseTicket $ticket
	 * @return TicketLog
	 * @throws BaseTicketException
	 */
	private function getResolutionEndLog(BaseTicket $ticket)
	{
		$logs = TicketLogQuery::create()
		->whereAdd(TicketLog::ID_BASE_TICKET, $ticket->getIdBaseTicket())
		->whereAdd(TicketLog::EVENT_TYPE, TicketLog::$EventTypes['Resolution_End_Time'])
		->useMemoryCache()
		->find();

		if( $logs->count() >= 2 ){
			throw new BaseTicketException("No pueden existir dos o mas logs de Resolution_End_Time");
		}

		return $logs->read();
	}

}