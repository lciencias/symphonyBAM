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
 * EmployeeValidator
 * @author chente
 *
 */
class EmployeeValidator extends PersonValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdEmployeeValidator();
        $this->initIdPersonValidator();
        $this->initIdPositionValidator();
        $this->initIdLocationValidator();
        $this->initIdAreaValidator();
        $this->initStatusEmployeeValidator();
        $this->initIsVipValidator();
        $this->initIdCompanyValidator();
    }

    /**
     *
     */
    protected function initIdEmployeeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_employee'] = $validator;
    }

    /**
     *
     */
    protected function initIdPersonValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_person'] = $validator;
    }

    /**
     *
     */
    protected function initIdPositionValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_position'] = $validator;
    }

    /**
     *
     */
    protected function initIdLocationValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_location'] = $validator;
    }

    /**
     *
     */
    protected function initIdAreaValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_area'] = $validator;
    }

    /**
     *
     */
    protected function initStatusEmployeeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['status_employee'] = $validator;
    }

    /**
     *
     */
    protected function initIsVipValidator()
    {
        $validator = new ZendValidator();
        $this->elements['is_vip'] = $validator;
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

 }
