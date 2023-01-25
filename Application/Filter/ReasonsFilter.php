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
 * ChannelFilter
 * @author chente
 *
 */
class ReasonsFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdReasonFilter();
        $this->initNameFilter();
        $this->initStatusFilter();
    }

    /**
     *
     */
    protected function initIdReasonFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_reason'] = $filter;
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
