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
 * UserFilter
 * @author chente
 *
 */
class UserFilter extends EmployeeFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdUserFilter();
        $this->initIdAccessRoleFilter();
        $this->initIdEmployeeFilter();
        $this->initUsernameFilter();
        $this->initPasswordFilter();
        $this->initStatusFilter();
        $this->initGroupFilter();
        $this->initFullNameFilter();
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
    protected function initIdAccessRoleFilter()
    {
        $filter = new ZendFilter();
        $this->elements['id_access_role'] = $filter;
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
    protected function initUsernameFilter()
    {
        $filter = new ZendFilter();
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['username'] = $filter;
    }

    /**
     *
     */
    protected function initPasswordFilter()
    {
        $filter = new ZendFilter();
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['password'] = $filter;
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
    protected function initGroupFilter()
    {
    	$filter = new ZendFilter();
    	$this->elements['group'] = $filter;
    }

    /**
     *
     * Enter description here ...
     */
    protected function initFullNameFilter()
    {
    	$validator = new ZendFilter();
    	$this->elements['full_name'] = $filter;
    }
}
