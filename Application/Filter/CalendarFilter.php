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

namespace Application\Filter;

use Zend_Filter as ZendFilter;

/**
 *
 * CalendarFilter
 * @author chente
 *
 */
class CalendarFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdCalendarFilter();
        $this->initDateFilter();
        $this->initIsWeekendFilter();
        $this->initIsHolidayFilter();
        $this->initNameHolidayFilter();
    }

    /**
     *
     */
    protected function initIdCalendarFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_calendar'] = $filter;
    }

    /**
     *
     */
    protected function initDateFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['date'] = $filter;
    }

    /**
     *
     */
    protected function initIsWeekendFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['is_weekend'] = $filter;
    }

    /**
     *
     */
    protected function initIsHolidayFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['is_holiday'] = $filter;
    }

    /**
     *
     */
    protected function initNameHolidayFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['name_holiday'] = $filter;
    }
}
