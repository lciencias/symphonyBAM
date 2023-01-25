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
 * CategoryFilter
 * @author chente
 *
 */
class CategoryFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdCategoryFilter();
        $this->initIdParentFilter();
        $this->initIdCompanyFilter();
        $this->initIdEscalationFilter();
        $this->initIdGroupFilter();
        $this->initIdServiceLevelFilter();
        $this->initNameFilter();
        $this->initStatusFilter();
        $this->initIsLeafFilter();
        $this->initNoteFilter();
    }

    /**
     *
     */
    protected function initIdCategoryFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_category'] = $filter;
    }

    /**
     *
     */
    protected function initIdParentFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_parent'] = $filter;
    }

    /**
     *
     */
    protected function initIdCompanyFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_company'] = $filter;
    }

    /**
     *
     */
    protected function initIdEscalationFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_escalation'] = $filter;
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
    protected function initStatusFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['status'] = $filter;
    }

    /**
     *
     */
    protected function initIsLeafFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['is_leaf'] = $filter;
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
