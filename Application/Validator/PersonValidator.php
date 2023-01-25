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
 * PersonValidator
 * @author chente
 *
 */
class PersonValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdPersonValidator();
        $this->initNameValidator();
        $this->initLastNameValidator();
        $this->initMiddleNameValidator();
        $this->initCurpValidator();
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
    protected function initLastNameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['last_name'] = $validator;
    }

    /**
     *
     */
    protected function initMiddleNameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['middle_name'] = $validator;
    }

    /**
     *
     */
    protected function initCurpValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['curp'] = $validator;
    }

 }
