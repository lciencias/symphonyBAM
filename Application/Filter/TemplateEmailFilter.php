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
 * TemplateEmailFilter
 * @author chente
 *
 */
class TemplateEmailFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdTemplateEmailFilter();
        $this->initIdCompanyFilter();
        $this->initNameFilter();
        $this->initSubjectFilter();
        $this->initBodyFilter();
        $this->initEventFilter();
        $this->initStatusFilter();
        $this->initToEmployeeFilter();
        $this->initToUserFilter();
        $this->initToGroupFilter();
        $this->initToEscalationFilter();
    }

    /**
     *
     */
    protected function initIdTemplateEmailFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_template_email'] = $filter;
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
    protected function initSubjectFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['subject'] = $filter;
    }

    /**
     *
     */
    protected function initBodyFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['body'] = $filter;
    }

    /**
     *
     */
    protected function initEventFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['event'] = $filter;
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
    protected function initToEmployeeFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['to_employee'] = $filter;
    }

    /**
     *
     */
    protected function initToUserFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['to_user'] = $filter;
    }

    /**
     *
     */
    protected function initToGroupFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['to_group'] = $filter;
    }

    /**
     *
     */
    protected function initToEscalationFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['to_escalation'] = $filter;
    }
}
