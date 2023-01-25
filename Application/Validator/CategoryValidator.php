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
 * CategoryValidator
 * @author chente
 *
 */
class CategoryValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdCategoryValidator();
        $this->initIdParentValidator();
        $this->initIdCompanyValidator();
        $this->initIdEscalationValidator();
        $this->initIdGroupValidator();
        $this->initIdServiceLevelValidator();
        $this->initNameValidator();
        $this->initStatusValidator();
        $this->initIsLeafValidator();
        $this->initNoteValidator();
    }

    /**
     *
     */
    protected function initIdCategoryValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_category'] = $validator;
    }

    /**
     *
     */
    protected function initIdParentValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getDigits());
        $this->elements['id_parent'] = $validator;
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
    protected function initIdEscalationValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_escalation'] = $validator;
    }

    /**
     *
     */
    protected function initIdGroupValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_group'] = $validator;
    }

    /**
     *
     */
    protected function initIdServiceLevelValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_service_level'] = $validator;
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
    protected function initIsLeafValidator()
    {
        $validator = new ZendValidator();
        $this->elements['is_leaf'] = $validator;
    }

    /**
     *
     */
    protected function initNoteValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['note'] = $validator;
    }

 }
