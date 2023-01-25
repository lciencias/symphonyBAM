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
 * UserValidator
 * @author chente
 *
 */
class UserValidator extends EmployeeValidator{

	/**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdUserValidator();
        $this->initIdAccessRoleValidator();
        $this->initIdEmployeeValidator();
        $this->initUsernameValidator();
        $this->initPasswordValidator();
        $this->initStatusValidator();
        $this->initGroupValidator();
    }

    /**
     *
     */
    protected function initIdUserValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_user'] = $validator;
    }

    /**
     *
     */
    protected function initIdAccessRoleValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_access_role'] = $validator;
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
    protected function initUsernameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['username'] = $validator;
    }

    /**
     *
     * Enter description here ...
     */
    protected function initPasswordValidator()
    {
    	$validator = new ZendValidator();
    	$validator->addValidator($this->getNotEmpty());
    	$validator->addValidator($this->getAlnumSpaces());
    	$this->elements['password'] = $validator;
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
    protected function initGroupValidator()
    {
    	$validator = new ZendValidator();
    	$validator->addValidator($this->getNotEmpty());
    	$this->elements['group'] = $validator;
    }

}
