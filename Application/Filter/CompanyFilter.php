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
 * CompanyFilter
 * @author chente
 *
 */
class CompanyFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdCompanyFilter();
        $this->initNameFilter();
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

}
