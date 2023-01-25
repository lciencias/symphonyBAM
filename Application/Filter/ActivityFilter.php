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
 * ActivityFilter
 * @author chente
 *
 */
class ActivityFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdActivityFilter();
        $this->initIdUserFilter();
        $this->initIdTicketFilter();
        $this->initStartDateFilter();
        $this->initEndDateFilter();
        $this->initNoteFilter();
    }

    /**
     *
     */
    protected function initIdActivityFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_activity'] = $filter;
    }

    /**
     *
     */
    protected function initIdUserFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_user'] = $filter;
    }

    /**
     *
     */
    protected function initIdTicketFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_ticket'] = $filter;
    }

    /**
     *
     */
    protected function initStartDateFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['start_date'] = $filter;
    }

    /**
     *
     */
    protected function initEndDateFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['end_date'] = $filter;
    }

    /**
     *
     */
    protected function initNoteFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['note'] = $filter;
    }
}
