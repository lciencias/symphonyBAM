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
 * PersonFilter
 * @author chente
 *
 */
class PersonFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdPersonFilter();
        $this->initNameFilter();
        $this->initLastNameFilter();
        $this->initMiddleNameFilter();
        $this->initCurpFilter();
    }

    /**
     *
     */
    protected function initIdPersonFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_person'] = $filter;
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
    protected function initLastNameFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['last_name'] = $filter;
    }

    /**
     *
     */
    protected function initMiddleNameFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['middle_name'] = $filter;
    }

    /**
     *
     */
    protected function initCurpFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['curp'] = $filter;
    }
}
