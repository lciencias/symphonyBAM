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
use Application\Model\Bean\TicketLog;
use Application\Model\Bean\Activity;
use Application\Query\AreaQuery;
use Application\Query\UserQuery;
use Application\Query\CategoryQuery;
use Application\Query\TicketTypeQuery;
use Application\Excel\ReportExcel;
use Application\Query\ActivityQuery;
use Application\Query\TicketQuery;
use Application\Query\TicketLogQuery;
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
class TicketReportController extends BaseController
{

    /**
     * @module Reports
     * @action Tickets
     */
    public function indexAction()
    {
        $this->view->contentTitle = $this->i18n->_("Ticket Report");
        $this->assignCombos();

        if( $this->getRequest()->isPost() ){
            $params = $this->getRequest()->getParams();
            $toExcel = $this->getRequest()->getParam('toExcel', false);
            $idCompany = $this->getRequest()->getParam('id_company');
            $tickets = TicketQuery::create()->filter($params)->find();

            if( $toExcel ){
                $excel = new ReportExcel();
                $excel->setHeaders(array(
                    'Status', 'Company','Location','Area','Registered By','Register Date','Ticket #',
                    'Description','Ticket Type', 'Category','Group','Channel','Assigned User',
                    'Last Status Change','Activities',
                ));
            }

            $summaryLabel = $this->getI18n()->_('Summary');
            $stats = array();
            $reportData = array();
            while ($tickets->valid()) {
                $ticket = $tickets->read();
                $ticketInfo = TicketInfo::factory($ticket);
                $array = $this->translateCombo($ticketInfo->toArray(''));
                $array = array_merge($array, $this->getExtraInfo($ticket));
                $seconds = $array['activities.duration']->getSeconds();
                $stats['Company'][$array['company.name']] += $seconds;
                $stats['Location'][$array['location.name']] += $seconds;
                $stats['Area'][$array['area.name']] += $seconds;
                $stats['Ticket Type'][$array['ticket_type.name']] += $seconds;

                $stats[$summaryLabel]['Total'] += $seconds;
                $reportData[] = $array;

                if( $toExcel ){
                    $excel->addCustomRow(array(
                        $array['ticket.status_name'], $array['company.name'], $array['location.name'], $array['area.name'],
                        $array['user.fullname'], $array['ticket.created'], $array['ticket.id_ticket'], $array['ticket.description'],
                        $array['ticket_type.name'], $array['category.name'], $array['group.name'], $array['channel.name'],
                        $array['assignedUser.fullname'], $array['ticket.status_changed_date'], $array['activities.duration']->toHuman()
                    ));
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

                $excel->toBrowser("TicketReport");
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
     * @param Ticket $activity
     * @return array
     */
    private function getExtraInfo(Ticket $ticket)
    {
        $array = array();

        $activities = ActivityQuery::create()->filter(array(Activity::ID_BASE_TICKET => $ticket->getIdBaseTicket()))->find();

        $seconds = $activities->foldLeft(0, function ($acc, Activity $activity){
            return $acc + $activity->getDuration()->getSeconds();
        });

        $lastStatusChange = TicketLogQuery::create()->filter(array(
            TicketLog::ID_BASE_TICKET => $ticket->getIdBaseTicket(),
            TicketLog::EVENT_TYPE => TicketLog::$EventTypes['Status'],
        ))->addDescendingOrderBy(TicketLog::DATE_LOG)->setLimit(1)->findOne();

        $date = '';
        if( $lastStatusChange instanceof TicketLog ){
            $date = $lastStatusChange->getDateLog();
        }

        return array(
            'activities.duration' => new Duration($seconds),
            'ticket.status_changed_date' => $date,
        );
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
        $this->view->allChannels = $channels->toCombo();
        $this->view->companies = $allOption + $companies->actives()->toCombo();
        $this->view->channels = $allOption + $channels->actives()->toCombo();
        $this->view->statuses = $allOption + array_map(array($this->getI18n(), '_'), Ticket::$Statuses);
    }

}


