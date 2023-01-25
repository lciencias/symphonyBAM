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
 * GroupFilter
 * @author chente
 *
 */
class GroupFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdGroupFilter();
        $this->initIdUserFilter();
        $this->initIdWorkweekFilter();
        $this->initNameFilter();
        $this->initStatusFilter();
    }

    /**
     *
     */
    protected function initIdGroupFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_group'] = $filter;
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
    protected function initIdWorkweekFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_workweek'] = $filter;
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
    protected function initStatusFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['status'] = $filter;
    }
}
