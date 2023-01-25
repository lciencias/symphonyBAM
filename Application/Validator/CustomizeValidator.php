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

namespace Application\Validator;


use Zend_Validate as ZendValidator;

/**
 *
 * CustomizeValidator
 * @author chente
 *
 */
class CustomizeValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdPcsCommonCustomizeValidator();
        $this->initIdCompanyValidator();
        $this->initLogoValidator();
        $this->initBackgroundColorValidator();
        $this->initForwardColorValidator();
        $this->initFontSizeValidator();
    }

    /**
     *
     */
    protected function initIdPcsCommonCustomizeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_pcs_common_customize'] = $validator;
    }

    /**
     *
     */
    protected function initIdCompanyValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_company'] = $validator;
    }

    /**
     *
     */
    protected function initLogoValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['logo'] = $validator;
    }

    /**
     *
     */
    protected function initBackgroundColorValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['background_color'] = $validator;
    }

    /**
     *
     */
    protected function initForwardColorValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['forward_color'] = $validator;
    }

    /**
     *
     */
    protected function initFontSizeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['font_size'] = $validator;
    }

 }
