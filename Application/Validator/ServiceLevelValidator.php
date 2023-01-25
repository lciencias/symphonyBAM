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
 * ServiceLevelValidator
 * @author chente
 *
 */
class ServiceLevelValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdServiceLevelValidator();
        $this->initNameValidator();
        $this->initResolutionTimeValidator();
        $this->initResponseTimeValidator();
        $this->initNoteValidator();
        $this->initStatusValidator();
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
    protected function initResolutionTimeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['resolution_time'] = $validator;
    }

    /**
     *
     */
    protected function initResponseTimeValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['response_time'] = $validator;
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

    /**
     *
     */
    protected function initStatusValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getDigits());
        $this->elements['status'] = $validator;
    }

 }
