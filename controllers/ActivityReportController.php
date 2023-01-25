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

use Application\Controller\BaseController;
use Application\Query\CompanyQuery;
use Application\Query\LocationQuery;
use Application\Model\Bean\Ticket;
use Application\Model\Bean\Activity;
use Application\Query\AreaQuery;
use Application\Query\UserQuery;
use Application\Query\CategoryQuery;
use Application\Query\TicketTypeQuery;
use Application\Excel\ReportExcel;
use Application\Query\ActivityQuery;
use Application\Query\TicketQuery;
use Application\Query\ChannelQuery;
use Application\Service\TicketInfo;
use PHPeriod\Duration;

/**
 * Clase IndexController que representa el controller para la ruta default
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class ActivityReportController extends BaseController
{

    /**
     * @module Reports
     * @action Activity
     */
    public function indexAction()
    {
        $this->view->contentTitle = $this->i18n->_("Activity Report");
        $this->assignCombos();

        if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();
            $toExcel = $this->getRequest()->getParam('toExcel', false);
            $idCompany = $this->getRequest()->getParam('id_company');
            $activities = ActivityQuery::create()->filter($params)->find();

            if( $toExcel ){
                $excel = new ReportExcel();
                $excel->setHeaders(array(
                    'Company','Location','Area','Registered By','Register Date','Ticket #','Ticket Type',
                    'Category','Group','Channel','Status','Assigned User','Activity Date','Activity Finished',
                    'Duration','Description',
                ));
            }

            $summaryLabel = $this->getI18n()->_('Summary');
            $stats = array();
            $reportData = array();
            while ($activities->valid()) {
                $activity = $activities->read();
                $ticket = TicketQuery::create()->whereAdd('BaseTicket.'.Ticket::ID_BASE_TICKET, $activity->getIdBaseTicket())->findOne();
               	if ($ticket instanceof  Ticket){
               		$ticketInfo = TicketInfo::factory($ticket);
               		$array = $this->translateCombo($ticketInfo->toArray(''));
               		$array = array_merge($array, $this->getActiviyArray($activity));
               		$seconds = $array['activity.duration_seconds'];
               		$stats['Company'][$array['company.name']] += $seconds;
               		$stats['Location'][$array['location.name']] += $seconds;
               		$stats['Area'][$array['area.name']] += $seconds;
               		$stats['Ticket Type'][$array['ticket_type.name']] += $seconds;
               		
               		$stats[$summaryLabel]['Total'] += $seconds;
               		$reportData[] = $array;
               		
               		if( $toExcel ){
               			$excel->addCustomRow(array(
               					$array['company.name'], $array['location.name'], $array['area.name'], $array['user.fullname'],
               					$array['ticket.created'], $array['ticket.id_ticket'], $array['ticket_type.name'], $array['category.name'],
               					$array['group.name'], $array['channel.name'], $array['ticket.status_name'], $array['assignedUser.fullname'],
               					$array['activity.start_date'], $array['activity.end_date'], $array['activity.duration'], $array['activity.note'],
               			));
               		}
               	}
            }

            $newStats = array();
            foreach ($stats as $key => $stat){
                $key = $this->i18n->_($key);
                foreach( $stat as $label => $seconds ){
                    $duration = new Duration($seconds);
                    $newStats[$key][$label] = $duration;
                }
            }

            if( $toExcel ){
                $last = count($reportData) + 5;
                $j = 0;
                foreach ($newStats as $category => $stat){
                    $i = 1;
                    $excel->getActiveSheet()->setCellValueByColumnAndRow($j, $last , (string) utf8_encode($category));
                    foreach ($stat as $name => $duration){
                        $activeSheet = $excel->getActiveSheet();
                        $activeSheet->setCellValueByColumnAndRow($j, $i+$last , (string) utf8_encode($name));
                        $activeSheet->setCellValueByColumnAndRow($j+1, $i+$last , (string) utf8_encode($duration->toHuman()));
                        $i++;
                    }
                    $j += 3;
                }

                $excel->toBrowser("ActivityReport");
            }

            if( $idCompany ){
                $categories = CategoryQuery::create()->whereAdd('id_company', $idCompany)->actives()->find();
                $this->view->nestedCategories = $categories->filterRoot()->toNestedArray($categories);
            }

            $this->view->stats = $newStats;
            $this->view->reportData = $reportData;
        }
    }

    /**
     *
     * @param Activity $activity
     * @return array
     */
    private function getActiviyArray(Activity $activity)
    {
        $array = array();
        foreach( $activity->toArray() as $field => $value ){
            $array['activity.'.$field] = $value;
        }
        $array['activity.duration_seconds'] = $activity->getDuration()->getSeconds();
        $array['activity.duration'] = $activity->getDuration()->toHuman();

        return $array;
    }

    /**
     *
     */
    private function assignCombos()
    {
        $allOption = array('' => $this->i18n->_("All"));

        $companies = CompanyQuery::create()->find();
        $channels = ChannelQuery::create()->find();

        $this->view->allCompanies = $companies->toCombo();
        $this->view->allChannels = $this->translateCombo($channels->toCombo());
        $this->view->companies = $allOption + $this->translateCombo($companies->actives()->toCombo());
        $this->view->channels = $allOption + $this->translateCombo($channels->actives()->toCombo());
        $this->view->statuses = $allOption + $this->translateCombo(Ticket::$Statuses);
    }

}


