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
 * EmployeeFilter
 * @author chente
 *
 */
class EmployeeFilter extends PersonFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdEmployeeFilter();
        $this->initIdPersonFilter();
        $this->initIdPositionFilter();
        $this->initIdLocationFilter();
        $this->initIdAreaFilter();
        $this->initStatusEmployeeFilter();
        $this->initIsVipFilter();
        $this->initIdCompanyFilter();
    }

    /**
     *
     */
    protected function initIdEmployeeFilter()
    {
        $filter = new ZendFilter();
        $this->elements['id_employee'] = $filter;
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
    protected function initIdPositionFilter()
    {
        $filter = new ZendFilter();
        $this->elements['id_position'] = $filter;
    }

    /**
     *
     */
    protected function initIdLocationFilter()
    {
        $filter = new ZendFilter();
        $this->elements['id_location'] = $filter;
    }

    /**
     *
     */
    protected function initIdAreaFilter()
    {
        $filter = new ZendFilter();
        $this->elements['id_area'] = $filter;
    }

    /**
     *
     */
    protected function initStatusEmployeeFilter()
    {
        $filter = new ZendFilter();
        $this->elements['status_employee'] = $filter;
    }

    /**
     *
     */
    protected function initIsVipFilter()
    {
        $filter = new ZendFilter();
        $this->elements['is_vip'] = $filter;
    }

    /**
     *
     */
    protected function initIdCompanyFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_company'] = $filter;
    }
}
