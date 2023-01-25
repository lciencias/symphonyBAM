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
 * CustomizeFilter
 * @author chente
 *
 */
class CustomizeFilter extends BaseFilter{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdPcsCommonCustomizeFilter();
        $this->initIdCompanyFilter();
        $this->initLogoFilter();
        $this->initBackgroundColorFilter();
        $this->initForwardColorFilter();
        $this->initFontSizeFilter();
    }

    /**
     *
     */
    protected function initIdPcsCommonCustomizeFilter()
    {
        $filter = new ZendFilter();        
        $this->elements['id_pcs_common_customize'] = $filter;
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
    protected function initLogoFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['logo'] = $filter;
    }

    /**
     *
     */
    protected function initBackgroundColorFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['background_color'] = $filter;
    }

    /**
     *
     */
    protected function initForwardColorFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['forward_color'] = $filter;
    }

    /**
     *
     */
    protected function initFontSizeFilter()
    {
        $filter = new ZendFilter();        
        $filter->addFilter($this->getStringTrim());
        $filter->addFilter($this->getUcwords());
        $this->elements['font_size'] = $filter;
    }
}
