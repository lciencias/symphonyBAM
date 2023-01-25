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

		if( $endDate->getTimestamp() <= $startDate->getTimestamp() ){
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

		if( $ticket->hasScheduledDate() ){
			$startDate = $ticket->getScheduledDateAsZendDate();
		}else{
			$startDate = $this->getResponseStartLog($ticket)->getDateLogAsZendDate();
		}

		// TODO pensar como sacar esta fecha
		$endDate = clone $startDate;
		$endDate->addDay(20);

		$periodCollection = $this->getWorkweekPeriod($workweek, $startDate, $endDate)
		->subtractCollection($this->getPausedPeriod($ticket));

		$storage->save($key, $periodCollection);

		return $periodCollection;
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
				die("<br>".$pausedLog->getDateLog()." ----  ".$now->get('yyyy-MM-dd HH:mm:ss'));
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