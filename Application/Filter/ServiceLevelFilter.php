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
 * ServiceLevelFilter
 * @author chente
 *
 */
class ServiceLevelFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdServiceLevelFilter();
        $this->initNameFilter();
        $this->initResolutionTimeFilter();
        $this->initResponseTimeFilter();
        $this->initNoteFilter();
        $this->initStatusFilter();
    }

    /**
     *
     */
    protected function initIdServiceLevelFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_service_level'] = $filter;
    }

    /**
     *
     */
    protected function initNameFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['name'] = $filter;
    }

    /**
     *
     */
    protected function initResolutionTimeFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['resolution_time'] = $filter;
    }

    /**
     *
     */
    protected function initResponseTimeFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['response_time'] = $filter;
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

    /**
     *
     */
    protected function initStatusFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['status'] = $filter;
    }
}
