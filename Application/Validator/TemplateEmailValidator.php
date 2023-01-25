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
 * TemplateEmailValidator
 * @author chente
 *
 */
class TemplateEmailValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdTemplateEmailValidator();
        $this->initIdCompanyValidator();
        $this->initNameValidator();
        $this->initSubjectValidator();
        $this->initBodyValidator();
        $this->initEventValidator();
        $this->initStatusValidator();
        $this->initToEmployeeValidator();
        $this->initToUserValidator();
        $this->initToGroupValidator();
        $this->initToEscalationValidator();
    }

    /**
     *
     */
    protected function initIdTemplateEmailValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_template_email'] = $validator;
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
    protected function initNameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['name'] = $validator;
    }

    /**
     *
     */
    protected function initSubjectValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['subject'] = $validator;
    }

    /**
     *
     */
    protected function initBodyValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['body'] = $validator;
    }

    /**
     *
     */
    protected function initEventValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['event'] = $validator;
    }

    /**
     *
     */
    protected function initStatusValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['status'] = $validator;
    }

    /**
     *
     */
    protected function initToEmployeeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['to_employee'] = $validator;
    }

    /**
     *
     */
    protected function initToUserValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['to_user'] = $validator;
    }

    /**
     *
     */
    protected function initToGroupValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['to_group'] = $validator;
    }

    /**
     *
     */
    protected function initToEscalationValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['to_escalation'] = $validator;
    }

 }
